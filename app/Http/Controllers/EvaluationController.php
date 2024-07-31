<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use App\Models\Driver;
use App\Services\EvaluationService;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    private Evaluation $evaluationModel;
    private EvaluationService $evaluationService;

    public function __construct(EvaluationService $evaluationService, Evaluation $evaluationModel)
    {
        $this->evaluationService = $evaluationService;
        $this->evaluationModel = $evaluationModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->evaluationModel::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEvaluationRequest $request)
    {
        $evaluation = $this->evaluationService->create(
            $request->validated(),
            $this->evaluationModel,
        );

        $driver = Driver::findOrFail($evaluation->driver_id);
        $avgRating = $driver->evaluations()->avg('rating');
        $driver->rating = round($avgRating);
        $driver->save();

        return response($evaluation);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $evaluation = $this->evaluationService->getById($id, $this->evaluationModel);
        if (!$evaluation) {
            return response([
                "message" => "Not Found",
            ], 404);
        }
        return response($evaluation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEvaluationRequest $request, int $id)
    {
        $evaluation = $this->evaluationService->getById($id, $this->evaluationModel);
        if (!$evaluation) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->evaluationService->edit(
            $evaluation,
            $request->validated(),
        );
        return response($evaluation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $evaluation = $this->evaluationService->getById($id, $this->evaluationModel);
        if (!$evaluation) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->evaluationService->delete(
            $evaluation,
        );
        return response([
            "message" => "success",
        ]);
    }
     public function getByDriverId(Request $request)
    {
        $driverId = $request->input('driver_id');
        $evaluations = $this->evaluationService->getByDriverId($driverId, $this->evaluationModel);
        return response($evaluations);
    }
}
