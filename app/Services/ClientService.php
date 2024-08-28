<?php
namespace App\Services;

use App\Helpers\GeneraleHelper;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class ClientService
{
    public function create(array $data, Client $ClientModel): Client
    {
        $Client = $ClientModel::create();
        // Create the user and associate it with the Client model
        GeneraleHelper::createUser($data, $Client);
        return $Client;
    }


    public function edit(User $Client, array $data): void
    {
        $Client->update($this->updatedData($data, $Client));
    }

    public function delete(User $Client, $id): void
    {
        $ClientClass = Client::find($id);
        if ($ClientClass) {
            $ClientClass->delete();
        }

        $Client->delete();
    }

    public function getById(int $id, User $ClientModel)
    {
        return $ClientModel::where('userable_type', 'App\Models\Client')->where('userable_id', $id)->first();
    }

    public function getAll(User $ClientModel)
    {
        return $ClientModel::where('userable_type', 'App\Models\Client')->paginate(10);
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
