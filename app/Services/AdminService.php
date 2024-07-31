<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;

class AdminService
{

    public function create(array $data, Admin $adminModel): Admin
    {
        return $adminModel::create($this->data($data));
    }


    public function edit(Admin $admin, array $data): void
    {
        $admin->update($this->data($data));
    }


    public function delete(Admin $admin): void
    {
        $admin->delete();
    }


    public function getById(int $id, Admin $adminModel)
    {
        return $adminModel::where('id', $id)->first();
    }

    public function getAll(Admin $adminModel): Collection
    {
        return $adminModel::all();
    }

    public function data($data): array
    {
        return
            [
                'user_id' => $data['user_id'],

            ];
    }
}
