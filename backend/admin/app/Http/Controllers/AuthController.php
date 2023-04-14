<?php

namespace App\Http\Controllers;

use App\Helpers\AppConstants;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
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
        $user->save();
        $accessToken = $user->createToken('authToken')->accessToken;

        return new ApiResource(['user' => $user, 'access_token' => $accessToken->token]);
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
            return new ApiResource(['error' => 'Unauthorized', 'status' => 401]);
        }

        $user = auth()->user();
        $accessToken = $user->createToken('authToken')->accessToken;

        return new ApiResource(['user' => $user, 'access_token' => $accessToken->token]);
    }

    /**
     * Logout a user.
     *
     * @return void
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return new ApiResource(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return void
     */
    public function refresh()
    {
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return new ApiResource(['access_token' => $accessToken->token]);
    }

    /**
     * Get the authenticated User.
     *
     * @return void
     */
    public function user(Request $request)
    {
        return new ApiResource(['user' => $request->user()]);
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

        if ($user) {
            $accessToken = $user->createToken('authToken')->accessToken;

            return new ApiResource(['user' => $user, 'access_token' => $accessToken->token]);
        }

        $user = new User([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'password' => Hash::make(Str::random(24)),
            'role' => AppConstants::ROLE_ADMIN,
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            'avatar' => $socialUser->getAvatar(),
            'email_verified_at' => now(),
        ]);

        $user->save();
        $accessToken = $user->createToken('authToken')->accessToken;

        return new ApiResource(['user' => $user, 'access_token' => $accessToken]);
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
        $accessToken = $socialite->__callStatic('driver', [$provider])->getAccessTokenResponse($request->code);
        $socialUser = $socialite->__callStatic('driver', [$provider])->userFromToken($accessToken['access_token']);

        $user = new User();
        $user = $user->__callStatic('where', ['email', $socialUser->getEmail()])->first();

        // Here the logic should be to redirect to the frontend with the access token

        if ($user) {
            $accessToken = $user->createToken('authToken')->accessToken;

            return redirect()->to(config('services.frontend.url').'/login#access_token='.$accessToken->token);
        }

        $user = new User([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'password' => Hash::make(
                Str::random(24)
            ),
            'role' => AppConstants::ROLE_ADMIN,
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            'avatar' => $socialUser->getAvatar(),
            'email_verified_at' => now(),
        ]);

        $user->save();
        $accessToken = $user->createToken('authToken')->accessToken;

        return redirect()->to(config('services.frontend.url').'/login#access_token='.$accessToken->token);
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

        return callStatic(Socialite::class, 'driver', $provider)->redirect();
    }
}
