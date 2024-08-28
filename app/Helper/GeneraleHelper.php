<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class GeneraleHelper
{
    /**
     * Create a user and associate it with a polymorphic model.
     *
     * @param array $userData
     * @param mixed $userableModel
     * @return User
     */
    public static function createUser(array $userData, $userableModel): User
    {
        // Create the user
        $user = new User();
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->image = isset($userData['image']) ? $userData['image'] : "";
        $user->password = Hash::make($userData['password']);
        $user->phone_number = $userData['phone_number'] ?? null;

        // Associate the user with the polymorphic model
        $user->userable()->associate($userableModel);

        // Save the user and the polymorphic association
        $user->save();

        return $user;
    }


    public static function uploadFile($request, string $path, $attribute, $extension = null): ?string
    {
        if ($request->hasFile($attribute)) {
            $file = $request->file($attribute);
            $fileName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

            // Move the uploaded file to the specified folder
            $file->move(public_path($path), $fileName);

            $fullUrl = secure_asset($path . '/' . $fileName);
            return $fullUrl;
        }
        return null;
    }

}
