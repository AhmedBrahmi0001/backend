<?php

namespace App\Services;

use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;

class PlaceService
{

    public function create(array $data, Place $placeModel): Place
    {
        return $placeModel::create($this->data($data));
    }


    public function edit(Place $place, array $data): void
    {
        $place->update($this->data($data));
    }


    public function delete(Place $place): void
    {
        $place->delete();
    }


    public function getById(int $id, Place $placeModel)
    {
        return $placeModel::where('id', $id)->first();
    }

    public function getAll(Place $placeModel): Collection
    {
        return $placeModel::all();
    }

    public function data($data): array
    {
        return
            [
                'name' =>$data['name'],
                'description' =>$data['description'],

            ];
    }
}
