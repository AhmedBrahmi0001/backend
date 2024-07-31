<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

class ClientService
{

    public function create(array $data, Client $clientModel): Client
    {
        return $clientModel::create($this->data($data));
    }


    public function edit(Client $client, array $data): void
    {
        $client->update($this->data($data));
    }


    public function delete(Client $client): void
    {
        $client->delete();
    }


    public function getById(int $id, Client $clientModel)
    {
        return $clientModel::where('id', $id)->first();
    }

    public function getAll(Client $clientModel): Collection
    {
        return $clientModel::all();
    }

    public function data($data): array
    {
        return
            [
                'user_id' => $data['user_id'],
            ];
    }
}
