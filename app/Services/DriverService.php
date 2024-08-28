<?php

namespace App\Services;

use App\Helpers\GeneraleHelper;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
class DriverService
{

    public function create(array $data, Driver $driverModel): Driver
    {
        $driver = $driverModel::create($this->data($data));
        GeneraleHelper::createUser($this->userData($data), $driver);
        return $driver;
    }


    public function edit(Driver $driver, array $data): void
    {
        // Update the User model associated with the Driver
        $user = $driver->user;
        $user->update($this->updateData($data, $user));
    }



    public function delete(Driver $driver): void
    {
        $driver->delete();
    }

    public function getById(int $id, User $driverModel)
    {
        // Find the user with the given id and userable_type 'App\Models\Driver'
        $user = $driverModel::where('userable_type', Driver::class)
                            ->where('userable_id', $id)
                            ->with(['userable.evaluations']) // Load the evaluations relationship from the related Driver model
                            ->first();
        return $user;
    }


    public function getAll(User $driverModel, array $filters): LengthAwarePaginator
    {
        // Query users that are associated with the Driver model
        $query = $driverModel::where('userable_type', Driver::class);

        if (isset($filters['low'])) {
            $query->whereHas('userable', function($query) use ($filters) {
                $query->where('price', '>=', $filters['low']);
            });
        }

        if (isset($filters['high'])) {
            $query->whereHas('userable', function($query) use ($filters) {
                $query->where('price', '<=', $filters['high']);
            });
        }

        if (isset($filters['rating'])) {
            $query->whereHas('userable', function($query) use ($filters) {
                $query->where('rating', '>=', $filters['rating']);
            });
        }

        if (isset($filters['place'])) {
            $query->whereHas('userable', function($query) use ($filters) {
                $query->where('place_id', $filters['place']);
            });
        }

        return $query->with(['userable.evaluations'])->paginate(100);
    }
    public function data($data): array
    {
        return
            [
                'name' =>$data['driver_name'],
                'price' =>$data['price'],
                'image' =>isset($data['driver_image']) ?  config('app.url') . '/' . ltrim($data['driver_image'], '/')   : "",
                'place_id' => $data['place_id'],
            ];
    }
    public function updateData($data, $model): array
    {
        return [
            'name' =>array_key_exists('name',$data) ? $data['name'] : $model->name,
            'email' => array_key_exists('email',$data) ? $data['email'] : $model->email,
            'password' => array_key_exists('password',$data) ? Hash::make($data['password']) : $model->password,
            'phone_number' => array_key_exists('phone_number',$data) ? $data['phone_number'] : $model->phone_number, // Optional field
        ];
    }
    public function userData($data): array
    {
        return [
            'name' =>array_key_exists('name',$data) ? $data['name'] : "",
            'email' => array_key_exists('email',$data) ? $data['email'] : "",
            'image' => array_key_exists('image',$data) ? config('app.url') . '/' . ltrim($data['image'], '/'): "",
            'password' => array_key_exists('password',$data) ? Hash::make($data['password']) : "",
            'phone_number' => array_key_exists('phone_number',$data) ? $data['phone_number'] : "", // Optional field
        ];
    }
}
