<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Client;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendError('Unauthorised');
        }

        $user = Auth::user();
        $user = User::find($user->id);
        $role = '';
        $driver = Driver::where('user_id', $user->id)->get();
        if($driver){
            $role = 'DRIVER';
        }
        $client = Client::where('user_id', $user->id)->get();
        if($client){
            $role = 'CLIENT';
        }
        if ($user->name == 'admin') {
            return $this->sendError('Unauthorised');
        }
        $response['id'] =  $user->id;
        $response['email'] =  $user->email;
        $response['name'] =  $user->name;
        $response['role'] =  $role;
        $response['accessToken'] = $user->refreshOrCreateToken();

        return $this->sendResponse($response, 'User logged in successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminlogin(Request $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendError('Unauthorised');
        }
        $user = Auth::user();
        $user = User::find($user->id);
        if($user->name !== 'admin'){
            return $this->sendError('Unauthorised');
        }
        $response['id'] =  $user->id;
        $response['email'] =  $user->email;
        $response['name'] =  $user->name;
        $response['role'] =  "ADMIN";
        $response['accessToken']  = $user->refreshOrCreateToken();

        return $this->sendResponse($response, 'User logged in successfully.');
    }

    /**
     * Update the authenticated user's API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(Request $request)
    {
        $token = $request->user()->refreshOrCreateToken();
        $response['access_token'] = $token;

        return $this->sendResponse($response, 'Token refreshed successfully');
    }

    /**
     * Delete authenticated user's API tokens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        return $this->sendResponse([], 'User logged out successfully');
    }

    /**
     * Get authenticated user data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        $response['user'] = $request->user();

        return $this->sendResponse($response, 'User logged out successfully');
    }

    /**
     * Register and login user
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Create the user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone_number' => $request->input('phone_number'),
        ]);

        // Log the user in
        Auth::login($user);

        // Check if the user is an admin
        if ($user->name === 'admin') {
            return $this->sendError('Unauthorized');
        }

        // Generate a token if using Sanctum
        $token = $user->refreshOrCreateToken();

        $response = [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'role' => 'CLIENT',
            'accessToken' => $token,
        ];

        return $this->sendResponse($response, 'User registered and logged in successfully.');
    }

}
