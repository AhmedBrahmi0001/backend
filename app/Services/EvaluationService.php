<?php

namespace App\Services;

use App\Models\Evaluation;
use Illuminate\Database\Eloquent\Collection;

class EvaluationService
{

    public function create(array $data, Evaluation $evaluationModel): Evaluation
    {
        return $evaluationModel::create($this->data($data));
    }


    public function edit(Evaluation $evaluation, array $data): void
    {
        $evaluation->update($this->data($data));
    }


    public function delete(Evaluation $evaluation): void
    {
        $evaluation->delete();
    }


    public function getById(int $id, Evaluation $evaluationModel)
    {
        return $evaluationModel::where('id', $id)->first();
    }
    public function getByDriverId(int $driverId, Evaluation $evaluationModel): Collection
    {
        return $evaluationModel::where('driver_id', $driverId)->get();
    }

    public function getAll(Evaluation $evaluationModel): Collection
    {
        return $evaluationModel::all();
    }

    public function data($data): array
    {
        return
            [
                'driver_id' => $data['driver_id'],
                'client_id' => $data['client_id'],
                'comment' => $data['comment'],
                'rating' => $data['rating']
            ];
    }
}
