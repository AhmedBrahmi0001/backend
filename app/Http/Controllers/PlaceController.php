<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Services\PlaceService;
use Illuminate\Support\Facades\Log;

class PlaceController extends Controller
{private Place $placeModel;
    private PlaceService $placeService;

    public function __construct(PlaceService $placeService, Place $placeModel)
    {
        $this->placeService = $placeService;
        $this->placeModel = $placeModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->placeModel::paginate(100);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlaceRequest $request)
    {
        try {
        $place = $this->placeService->create(
            $request->validated(),
            $this->placeModel,
        );
        return response($place);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $place = $this->placeService->getById($id, $this->placeModel);
        if (!$place) {
            return response([
                "message" => "Not Found",
            ], 404);
        }
        return response($place);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlaceRequest $request, int $id)
    {
        $place = $this->placeService->getById($id, $this->placeModel);
        if (!$place) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->placeService->edit(
            $place,
            $request->validated(),
        );
        return response($place);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $place = $this->placeService->getById($id, $this->placeModel);
        if (!$place) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->placeService->delete(
            $place,
        );
        return response([
            "message" => "success",
        ]);
    }
}
