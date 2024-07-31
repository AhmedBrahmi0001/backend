<?php

namespace App\Services;

use App\Models\Complaint;
use Illuminate\Database\Eloquent\Collection;

class ComplaintService
{

    public function create(array $data, Complaint $complaintModel): Complaint
    {
        return $complaintModel::create($this->data($data));
    }


    public function edit(Complaint $complaint, array $data): void
    {
        $complaint->update($this->data($data));
    }


    public function delete(Complaint $complaint): void
    {
        $complaint->delete();
    }


    public function getById(int $id, Complaint $complaintModel)
    {
        return $complaintModel::where('id', $id)->first();
    }

    public function getAll(Complaint $complaintModel): Collection
    {
        return $complaintModel::all();
    }

    public function data($data): array
    {
        return
            [
                'title' => $data['title'],
                'description' => $data['description'],
                'etat' => $data['etat']
            ];
    }
}
