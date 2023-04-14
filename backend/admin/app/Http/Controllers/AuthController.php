<?php

namespace App\Http\Controllers;

use App\Helpers\AppConstants;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;

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

        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;

        return new ApiResource(['user' => $user, 'access_token' => $accessToken]);
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

        return new ApiResource(['user' => $user, 'access_token' => $accessToken]);
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

        return new ApiResource(['access_token' => $accessToken]);
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
}
