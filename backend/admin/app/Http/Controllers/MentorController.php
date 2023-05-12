<?php

namespace App\Http\Controllers;

use App\Helpers\AppConstants;
use App\Http\Resources\ApiResource;
use App\Models\User;
use App\Notifications\InviteMentor;
use App\Notifications\InviteMentorManager;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    protected $role = AppConstants::ROLE_MENTOR;

    public function __construct($role = null)
    {
        if ($role) {
            $this->role = $role;
        }
    }

    /**
     * Get all mentors.
     */
    public function getMentors(Request $request)
    {
        $mentors = (new UserController())->searchUsersByRole($request, $this->role);

        return new ApiResource($mentors);
    }

    /**
     * Search mentors.
     *
     * @param mixed $keyword
     */
    public function searchMentors(Request $request, $keyword)
    {
        $mentors = (new UserController())->searchUsersByRole($request, $this->role, $keyword);

        return new ApiResource($mentors);
    }

    /**
     * Get specific mentor.
     *
     * @param mixed $mentor_id
     */
    public function getMentor($mentor_id)
    {
        $mentor = callStatic(User::class, 'where', 'id', $mentor_id)
            ->where('role', $this->role)
            ->first();

        return new ApiResource(['data' => $mentor]);
    }

    /**
     * Invite mentor.
     */
    public function inviteMentor(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        $user = callStatic(User::class, 'create', [
            'name' => sprintf('User %s', strHelper('random', 5)),
            'email' => $request->email,
            'role' => $this->role,
            'password' => bcrypt(strHelper('random', 12)),
        ]);

        switch ($this->role) {
            case AppConstants::ROLE_MENTOR:
                $user->addTag(AppConstants::MENTOR_TAG);
                $user->notify(new InviteMentor());

                break;

            case AppConstants::ROLE_MENTOR_MANAGER:
                $user->addTag(AppConstants::MENTOR_MANAGER_TAG);
                $user->notify(new InviteMentorManager());

                break;
        }

        return new ApiResource(['data' => $user]);
    }

    /**
     * Update mentor.
     *
     * @param mixed $mentor_id
     */
    public function updateMentor(Request $request, $mentor_id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = callStatic(User::class, 'where', 'id', $mentor_id)
            ->where('role', $this->role)
            ->first();

        if (! $user) {
            return new ApiResource([
                'error' => 'Mentor not found',
                'status' => 404,
            ]);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return new ApiResource(['data' => $user]);
    }

    /**
     * Delete mentor.
     *
     * @param mixed $mentor_id
     */
    public function deleteMentor($mentor_id)
    {
        $user = callStatic(User::class, 'where', 'id', $mentor_id)
            ->where('role', $this->role)
            ->first();

        if (! $user) {
            return new ApiResource([
                'error' => 'Mentor not found',
                'status' => 404,
            ]);
        }

        $user->delete();

        return new ApiResource(['data' => $user]);
    }
}
