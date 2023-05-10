<?php

namespace App\Http\Controllers;

use App\Helpers\AppConstants;
use App\Http\Resources\ApiResource;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @param User $user
     */
    protected function createAuthToken($user, array $scopes = ['*']): array
    {
        // Update the last login time and IP
        $user->last_login_at = now();
        $user->last_login_ip = request()->ip();
        $user->save();

        // Get expiry time from config
        $expiryTime = config('sanctum.expiration');
        $expiryTime = $expiryTime ? now()->addMinutes($expiryTime) : null;
        $token = $user->createToken('authToken', $scopes, $expiryTime);

        return [
            'access_token' => $token->plainTextToken,
            'expires_at' => $token->accessToken->expires_at->timestamp,
            'expires_in' => $token->accessToken->expires_at->diffInSeconds(now()),
        ];
    }

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function register(Request $request)
    {
        // Validate the user, return error using the ApiResource
        $validator = validator($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return new ApiResource(['errors' => $validator->errors(), 'status' => 422]);
        }

        $validatedData = $validator->validated();
        $validatedData['password'] = bcrypt($request->password);
        $validatedData['role'] = AppConstants::ROLE_ADMIN;

        $user = new User($validatedData);

        // If localhost, or ipaddress is 127.0.0.1 then verify the user automatically
        if ('127.0.0.1' === request()->ip() ||
            'localhost' === request()->ip() ||
            app()->environment('local', 'testing') ||
            config('app.debug')
        ) {
            $user->email_verified_at = now();
        }

        $user->save();

        if (! $user->email_verified_at) {
            $user->sendEmailVerificationNotification();
        }

        // Create a token for the user
        $accessToken = $this->createAuthToken($user);

        return new ApiResource([
            'user' => $user,
            'status' => 201,
            'message' => 'User successfully registered',
        ] + $accessToken);
    }

    /**
     * Login a user.
     *
     * @return void
     */
    public function login(Request $request)
    {
        // Validate the user, return error using the ApiResource
        $validator = validator($request->all(), [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return new ApiResource(['errors' => $validator->errors(), 'status' => 422]);
        }

        $credentials = request(['email', 'password']);

        if (! auth()->attempt($credentials)) {
            return new ApiResource(['error' => 'Invalid username or password.', 'status' => 401]);
        }

        $user = auth()->user();
        $accessToken = $this->createAuthToken($user);

        return new ApiResource([
            'user' => $user,
            'message' => 'User successfully logged in',
        ] + $accessToken);
    }

    /**
     * Logout a user.
     *
     * @return void
     */
    public function logout(Request $request)
    {
        // Check if the user is logged in
        $request->user()->currentAccessToken()->delete();

        return new ApiResource(['message' => 'Successfully logged out']);
    }

    /**
     * Logout a user from all devices.
     * This will revoke all the tokens for the user.
     */
    public function logoutAll(Request $request)
    {
        // Check if the user is logged in
        $request->user()->tokens()->delete();

        return new ApiResource(['message' => 'Successfully logged out from all devices']);
    }

    /**
     * Logout a user from a specific device.
     *
     * @param mixed $tokenId
     */
    public function logoutDevice(Request $request, $tokenId)
    {
        // Check if the user is logged in
        $request->user()->tokens()->where('id', $tokenId)->delete();

        return new ApiResource(['message' => 'Successfully logged out from the device']);
    }

    /**
     * Logout a user from all devices except the current one.
     */
    public function logoutOther(Request $request)
    {
        // Check if the user is logged in
        $request->user()->tokens()->where('id', '!=', $request->user()->currentAccessToken()->id)->delete();

        return new ApiResource(['message' => 'Successfully logged out from all devices except the current one']);
    }

    /**
     * Refresh a token.
     *
     * @return void
     */
    public function refresh()
    {
        $accessToken = $this->createAuthToken(auth()->user());

        return new ApiResource([
            'message' => 'Token successfully refreshed',
        ] + $accessToken);
    }

    /**
     * Get the authenticated User.
     *
     * @return void
     */
    public function user()
    {
        return (new UserController())->getUser();
    }

    /**
     * Login with social media.
     *
     * @return void
     */
    public function socialLogin(Request $request)
    {
        // Validate the user, return error using the ApiResource
        $validator = validator($request->all(), [
            'provider' => 'required|string',
            'access_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(['errors' => $validator->errors(), 'status' => 422]);
        }

        $provider = $request->provider;
        $accessToken = $request->access_token;

        $socialite = new Socialite();
        $socialUser = $socialite->__callStatic('driver', [$provider])->userFromToken($accessToken);
        $user = User::where('email', $socialUser->getEmail())->first();

        if (! $user) {
            $user = new User([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => callStatic(Hash::class, 'make', strHelper('random', 24)),
                'role' => AppConstants::ROLE_ADMIN,
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'email_verified_at' => now(),
            ]);

            $user->save();
        }

        $accessToken = $this->createAuthToken($user);

        return new ApiResource([
            'user' => $user,
        ] + $accessToken);
    }

    /**
     * Social login callback.
     *
     * @param mixed $provider
     */
    public function socialLoginCallback(Request $request, $provider)
    {
        // Validate list of providers
        $providers = AppConstants::SOCIAL_PROVIDERS;

        if (! in_array($provider, $providers)) {
            return new ApiResource(['error' => 'Invalid provider']);
        }

        // Get access token, given state and code from google callback
        $socialite = new Socialite();

        try {
            $accessToken = $socialite->__callStatic('driver', [$provider])->getAccessTokenResponse($request->code);
            $socialUser = $socialite->__callStatic('driver', [$provider])->userFromToken($accessToken['access_token']);
        } catch (\Exception|\Throwable $e) {
            callStatic(Log::class, 'error', $e);

            return redirect()->away(config('services.frontend.url').'/login?error=Invalid+credentials');
        }

        $user = new User();
        $user = $user->__callStatic('where', ['email', $socialUser->getEmail()])->first();

        // Here the logic should be to redirect to the frontend with the access token
        if (! $user) {
            $user = new User([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => callStatic(Hash::class, 'make', strHelper('random', 24)),
                'role' => AppConstants::ROLE_ADMIN,
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'email_verified_at' => now(),
            ]);

            $user->save();
        }

        $accessToken = $this->createAuthToken($user);
        $query = http_build_query($accessToken);
        $url = config('services.frontend.url').'/login?'.$query;

        return redirect()->away($url);
    }

    /**
     * Social login redirect.
     */
    public function socialLoginRedirect(Request $request)
    {
        $provider = $request->provider;

        // Validate list of providers
        $providers = AppConstants::SOCIAL_PROVIDERS;

        if (! in_array($provider, $providers)) {
            return new ApiResource(['error' => 'Invalid provider, valid providers are: '.implode(',', $providers), 'status' => 422]);
        }

        return new ApiResource([
            'url' => callStatic(Socialite::class, 'driver', $provider)->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    /**
     * Reset password.
     */
    public function resetPassword(Request $request)
    {
        // Validate the user, return error using the ApiResource
        $validator = validator($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return new ApiResource(['errors' => $validator->errors(), 'status' => 422]);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return new ApiResource(['error' => 'User not found', 'status' => 404]);
        }

        $token = callStatic(Str::class, 'random', 60);

        callStatic(DB::class, 'table', 'password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $user->notify(new ResetPasswordNotification($token));

        return new ApiResource(['message' => 'Password reset link sent to your email']);
    }

    /**
     * Check token validity.
     */
    public function checkToken(Request $request)
    {
        // Validate the user, return error using the ApiResource
        $validator = validator($request->all(), [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(['errors' => $validator->errors(), 'status' => 422]);
        }

        $passwordReset = callStatic(DB::class, 'table', 'password_resets')->where('token', $request->token)->first();

        if (! $passwordReset) {
            return new ApiResource(['error' => 'Invalid token', 'status' => 422]);
        }

        // If token is older than 1 hour, return error
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            return new ApiResource(['error' => 'Token expired', 'status' => 422]);
        }

        return new ApiResource(['message' => 'Token is valid']);
    }

    /**
     * Change password.
     */
    public function changePassword(Request $request)
    {
        // Validate the user, return error using the ApiResource
        $validator = validator($request->all(), [
            'token' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return new ApiResource(['errors' => $validator->errors(), 'status' => 422]);
        }

        $passwordReset = callStatic(DB::class, 'table', 'password_resets')->where('token', $request->token)->first();

        if (! $passwordReset) {
            return new ApiResource(['error' => 'Invalid token', 'status' => 422]);
        }

        // If token is older than 1 hour, return error
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            return new ApiResource(['error' => 'Token expired', 'status' => 422]);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (! $user) {
            return new ApiResource(['error' => 'User not found', 'status' => 404]);
        }

        $user->password = callStatic(Hash::class, 'make', $request->password);
        $user->save();

        callStatic(DB::class, 'table', 'password_resets')->where('email', $user->email)->delete();

        return new ApiResource(['message' => 'Password changed successfully']);
    }

    /**
     * Update user password, for logged in users.
     */
    public function updatePassword(Request $request)
    {
        // Validate the user, return error using the ApiResource
        $validator = validator($request->all(), [
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return new ApiResource(['errors' => $validator->errors(), 'status' => 422]);
        }

        $user = $request->user();

        if (! callStatic(Hash::class, 'check', $request->old_password, $user->password)) {
            return new ApiResource(['error' => 'Invalid old password', 'status' => 422]);
        }

        $user->password = callStatic(Hash::class, 'make', $request->password);
        $user->save();

        // Log the user out of all other devices
        $this->logoutOther($request);

        return new ApiResource(['message' => 'Password changed successfully']);
    }

    /**
     * Verify email.
     */
    public function verifyEmail(Request $request)
    {
        // Validate the user, return error using the ApiResource
        $validator = validator($request->all(), [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(['errors' => $validator->errors(), 'status' => 422]);
        }

        $user = User::where('email_verification_token', $request->token)->first();

        if (! $user) {
            return new ApiResource(['error' => 'Invalid token', 'status' => 422]);
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        return new ApiResource(['message' => 'Email verified successfully']);
    }
}
