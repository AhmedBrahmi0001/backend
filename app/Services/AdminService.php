<?php
namespace App\Services;

use App\Helpers\GeneraleHelper;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    public function create(array $data, Admin $adminModel): Admin
    {
        $admin = $adminModel::create();
        // Create the user and associate it with the admin model
        GeneraleHelper::createUser($data, $admin);
        return $admin;
    }


    public function edit(User $admin, array $data): void
    {
        $admin->update($this->updatedData($data, $admin));
    }

    public function delete(User $admin, $id): void
    {
        $adminClass = Admin::find($id);
        if ($adminClass) {
            $adminClass->delete();
        }

        $admin->delete();
    }

    public function getById(int $id, User $adminModel)
    {
        return $adminModel::where('userable_type', 'App\Models\Admin')->where('userable_id', $id)->first();
    }

    public function getAll(User $adminModel)
    {
        return $adminModel::where('userable_type', 'App\Models\Admin')->paginate(10);
    }

    public function updatedData($data, $model): array
    {
        return [
            'name' =>array_key_exists('name',$data) ? $data['name'] : $model->name,
            'email' => array_key_exists('email',$data) ? $data['email'] : $model->email,
            'password' => array_key_exists('password',$data) ? Hash::make($data['password']) : $model->password,
            'phone_number' => array_key_exists('phone_number',$data) ? $data['phone_number'] : $model->phone_number, // Optional field
        ];
    }
}
