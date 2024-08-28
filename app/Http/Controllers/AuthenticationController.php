<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Admin;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        // Validate incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendError('Unauthorized', 401);
        }

        $user = User::find(Auth::id());

        // Determine the role of the user based on the polymorphic relation
        $role = '';
        $userable = $user->userable; // Get the related model

        if ($userable instanceof Driver) {
            $role = 'DRIVER';
        } elseif ($userable instanceof Client) {
            $role = 'CLIENT';
        } elseif ($userable instanceof Admin) {
            return $this->sendError('Unauthorized', 403); // Admins are not allowed
        }

        // Prepare the response data
        $response = [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'role' => $role,
            'accessToken' => $user->refreshOrCreateToken(),
        ];

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
        $user = User::find(Auth::id());
        $userable = $user->userable;
        if($userable instanceof Driver){
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
        // Create a new Client instance
        $client = Client::create([
            // Add other Client-specific fields here if needed
        ]);

        // Create a new User instance
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->phone_number = $request->input('phone_number');

        // Set the userable_id and userable_type explicitly
        $user->userable_id = $client->id;
        $user->userable_type = Client::class; // or 'App\Models\Client' if you're not using class-based references

        // Save the user with the associated client
        $user->save();

        // Log the user in
        Auth::login($user);

        // Generate an access token
        $token = $user->refreshOrCreateToken();

        // Prepare the response
        $response = [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'role' => 'CLIENT',
            'accessToken' => $token,
        ];

        // Return the response
        return $this->sendResponse($response, 'User registered and logged in successfully.');
    }
}
