<?php

namespace App\Http\Controllers;

use App\Helpers\AppConstants;
use App\Http\Resources\ApiResource;
use App\Models\User;
use App\Models\UserMetadata;
use App\Rules\CheckPreferences;
use App\Rules\ValidateCity;
use App\Rules\ValidateState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    protected function updateWebsiteMetadata($request, $user)
    {
        // Social links, this will be stored as user metadata i.e. UserMetadata model
        if ($request->website) {
            $user->setMetadata('my_website', 'my_website', 'url', 'website', [
                'url' => $request->website,
            ]);
        }
    }

    protected function updateUserAvatar($request, $user)
    {
        // Avatar
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                $oldAvatar = storage_path('app/public/'.str_replace(route('user.avatar', ['filename' => '']), '', $user->avatar));

                if (file_exists($oldAvatar)) {
                    unlink($oldAvatar);
                }
            }

            $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('avatars', $avatarName);
            $user->avatar = route('user.avatar', ['filename' => $avatarName]);
        }
    }

    protected function updateUserSocialLinks($request, $user)
    {
        if ($request->github_username) {
            $user->setMetadata('github_username', $request->github_username, 'string', 'social', [
                'url' => 'https://github.com/'.$request->github_username,
            ]);
        }

        if ($request->linkedin_username) {
            $user->setMetadata('linkedin_username', $request->linkedin_username, 'string', 'social', [
                'url' => 'https://linkedin.com/in/'.$request->linkedin_username,
            ]);
        }

        if ($request->twitter_username) {
            $user->setMetadata('twitter_username', $request->twitter_username, 'string', 'social', [
                'url' => 'https://twitter.com/'.$request->twitter_username,
            ]);
        }

        if ($request->instagram_username) {
            $user->setMetadata('instagram_username', $request->instagram_username, 'string', 'social', [
                'url' => 'https://instagram.com/'.$request->instagram_username,
            ]);
        }
    }

    protected function updateUserTags($request, $user)
    {
        if ($request->tags) {
            $user->setMetadata('tags', $request->tags, 'array', 'tags', [
                'tags' => $request->tags,
            ]);
        }
    }

    /**
     * Update user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'nullable|string|max:255',
            // 'email' => 'nullable|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:255|phone:INTERNATIONAL|unique:users,phone,'.$user->id,
            'country' => 'nullable|string|max:255|exists:countries,code',
            'state' => ['nullable', 'string', 'max:255', 'exists:states,code', new ValidateState($request->country)],
            'city' => ['nullable', 'string', 'max:255', 'exists:cities,name', new ValidateCity($request->country, $request->state)],
            'address' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:255',
            'about_me' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url|max:255',
            'github_username' => 'nullable|string|max:255',
            'linkedin_username' => 'nullable|string|max:255',
            'twitter_username' => 'nullable|string|max:255',
            'instagram_username' => 'nullable|string|max:255',
            'timezone' => 'nullable|string|max:255|in:'.implode(',', array_keys(AppConstants::TIMEZONES)),
            'tags' => 'nullable|array',
        ]);

        // // If email is changed, then send verification email
        // if ($request->email && $request->email != $user->email) {
        //     $user->email_verified_at = null;
        //     $user->sendEmailVerificationNotification();
        // }

        // User model
        foreach ($request->only(['name', 'email', 'phone', 'about_me', 'country', 'state', 'city', 'address', 'zip_code', 'timezone']) as $key => $value) {
            if ($value) {
                $user->$key = $value;
            }
        }

        // Update user social links
        $this->updateUserSocialLinks($request, $user);

        // Update user website metadata
        $this->updateWebsiteMetadata($request, $user);

        // Update user avatar
        $this->updateUserAvatar($request, $user);

        // Tags metadata
        $this->updateUserTags($request, $user);
        $user->save();

        return new ApiResource(['data' => $user]);
    }

    /**
     * Get the user avatar.
     *
     * @param mixed $filename
     */
    public function getAvatar($filename)
    {
        $path = storage_path('app/avatars/'.$filename);

        if (callStatic(File::class, 'exists', $path)) {
            return response()->file($path);
        }

        // Return 404 if avatar not found
        abort(404);
    }

    /**
     * Get the user.
     */
    public function getUser()
    {
        return new ApiResource(['data' => auth()->user()]);
    }

    /**
     * Get user preferences.
     */
    public function getPreferences()
    {
        /**
         * @var \App\Models\User
         */
        $user = auth()->user();
        $preferences = $user->getPreferences();

        // If data is empty, then create default preferences
        if (empty($preferences) || 0 == count($preferences)) {
            foreach (AppConstants::PREFERENCES as $key => $value) {
                $user->setPreference($key, $value);
            }

            $preferences = $user->getPreferences();
        }

        return new ApiResource(['data' => $preferences]);
    }

    /**
     * Update user preferences.
     */
    public function updatePreferences(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'preferences' => 'required|array',
            'preferences.*' => [
                'required',
                new CheckPreferences($request->preferences),
            ],
        ]);

        $preferences = $request->preferences;

        foreach ($preferences as $key => $value) {
            $user->setPreference($key, $value);
        }

        return new ApiResource(['data' => $user->getPreferences()]);
    }

    /**
     * Update the avatar.
     */
    public function updateAvatar(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Avatar
        if ($request->hasFile('avatar')) {
            $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('avatars', $avatarName);
            $user->avatar = route('user.avatar', ['filename' => $avatarName]);
        }

        $user->save();

        return new ApiResource(['data' => $user]);
    }

    /**
     * Get avatar url for the user.
     */
    public function getAvatarUrl(Request $request)
    {
        $user = $request->user();

        return new ApiResource(['avatar_url' => $user->avatar_url]);
    }

    /**
     * Get specific user.
     *
     * @param mixed $user_id
     */
    public function getUserById($user_id)
    {
        $user = callStatic(User::class, 'find', $user_id);

        if (! $user) {
            abort(404);
        }

        // Remove sensitive data
        $user->makeHidden(['phone', 'email_verified_at', 'created_at', 'updated_at', 'unread_messages_count', 'unread_notifications_count']);

        return new ApiResource(['data' => $user]);
    }

    /**
     * Get all users.
     */
    public function getUsers()
    {
        $users = callStatic(User::class, 'where', 'id', '!=', auth()->id())->paginate(10);

        // Remove sensitive data
        $users->makeHidden(['phone', 'email_verified_at', 'created_at', 'updated_at', 'unread_messages_count', 'unread_notifications_count']);

        return new ApiResource($users);
    }

    /**
     * Search users.
     *
     * @param mixed $keyword
     */
    public function searchUsers($keyword)
    {
        $users = callStatic(User::class, 'where', 'name', 'LIKE', '%'.$keyword.'%')
            ->orWhere('email', 'LIKE', '%'.$keyword.'%')
            ->orWhere('phone', 'LIKE', '%'.$keyword.'%')
            ->paginate(10);

        // Remove sensitive data
        $users->makeHidden(['phone', 'email_verified_at', 'created_at', 'updated_at', 'unread_messages_count', 'unread_notifications_count']);

        return new ApiResource($users);
    }

    /**
     * Alive check.
     */
    public function alive()
    {
        return new ApiResource(['data' => 'alive']);
    }

    /**
     * Search users by role.
     */
    public function searchUsersByRole(Request $request, string $role)
    {
        $request->validate([
            'keyword' => 'nullable|string|max:255',
        ]);

        $users = callStatic(User::class, 'where', 'role', $role)
            ->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->keyword.'%')
                    ->orWhere('email', 'LIKE', '%'.$request->keyword.'%')
                    ->orWhere('phone', 'LIKE', '%'.$request->keyword.'%');
            })
            ->paginate(10);

        // Remove sensitive data
        $users->makeHidden(['phone', 'email_verified_at', 'created_at', 'updated_at', 'unread_messages_count', 'unread_notifications_count']);

        return new ApiResource($users);
    }

    /**
     * Search users by tag.
     */
    public function searchUsersByMetadata(Request $request, string $metadata_group, string $value)
    {
        $request->validate([
            'keyword' => 'nullable|string|max:255',
        ]);

        $users = callStatic(UserMetadata::class, 'where', 'group', $metadata_group)
            ->where('value', 'LIKE', '%'.$value.'%')
            ->join('users', 'users.id', '=', 'user_metadata.user_id')
            ->select('users.id')
            ->where(function ($query) use ($request) {
                $query->where('users.name', 'LIKE', '%'.$request->keyword.'%')
                    ->orWhere('users.email', 'LIKE', '%'.$request->keyword.'%')
                    ->orWhere('users.phone', 'LIKE', '%'.$request->keyword.'%');
            })
            ->paginate(10);

        // For each user, get the user model
        foreach ($users as $key => $user) {
            $users[$key] = callStatic(User::class, 'find', $user->id);
        }

        // Remove sensitive data
        $users->makeHidden(['phone', 'email_verified_at', 'created_at', 'updated_at', 'unread_messages_count', 'unread_notifications_count']);

        return new ApiResource($users);
    }
}
