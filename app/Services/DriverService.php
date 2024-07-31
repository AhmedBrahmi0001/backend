<?php

namespace App\Services;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DriverService
{

    public function create(array $data, Driver $driverModel): Driver
    {
        return $driverModel::create($this->data($data));
    }


    public function edit(Driver $driver, array $data): void
    {
        $driver->update($this->data($data));
    }


    public function delete(Driver $driver): void
    {
        $driver->delete();
    }


    public function getById(int $id, Driver $driverModel)
    {
        return $driverModel::where('id', $id)->with(['evaluations'])->first();

    }

    public function getAll(Driver $driverModel, array $filters): LengthAwarePaginator
    {
        $query = $driverModel::query();

        if (isset($filters['low'])) {
            $query->where('price', '>=', $filters['low']);
        }

        if (isset($filters['high'])) {
            $query->where('price', '<=', $filters['high']);
        }

        if (isset($filters['rating'])) {
            $query->where('rating', '>=', $filters['rating']);
        }

        if (isset($filters['place'])) {
            $query->where('place_id', $filters['place']);
        }

        return $query->with('evaluations')->paginate(100);
    }

    public function data($data): array
    {
        return
            [

                'name' =>$data['name'],
                'price' =>$data['price'],
                'image' =>$data['image'],
                'user_id' => $data['user_id'],
                'place_id' => $data['place_id'],

            ];
    }
}
