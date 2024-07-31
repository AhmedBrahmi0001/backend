<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\User;
use App\Services\DriverService;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    private Driver $driverModel;
    private DriverService $driverService;

    public function __construct(DriverService $driverService, Driver $driverModel, private User $userModel)
    {
        $this->driverService = $driverService;
        $this->driverModel = $driverModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['low', 'high', 'rating', 'place']);
        return $this->driverService->getAll($this->driverModel, $filters);
    }
    /*$filter = $request->query('filter');

 $query = Driver::query();

 if ($filter === 'rate') {
     $query->orderBy('rating', 'desc');
 } elseif ($filter === 'price') {
     $query->orderBy('price', 'asc');
 } elseif ($filter === 'place') {
     // Implement place-based filtering logic if required*/

    /*$drivers = $query->get();*/

    //return response()->json($drivers);


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDriverRequest $request)
    {
        $user = $this->userModel::create($request->validated());
        $driver = $this->driverService->create(
            $request->except(['driver_name', 'driver_image', 'image', 'name']) + [
                'image' => isset($request->validated()['driver_image']) ?? 'test.png',
                'name' => $request->validated()['driver_name'],
                'user_id' => $user->id
            ],
            $this->driverModel,
        );

        return response($driver);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $driver = $this->driverService->getById($id, $this->driverModel);
        if (!$driver) {
            return response([
                "message" => "Not Found",
            ], 404);
        }
        return response($driver);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDriverRequest $request, int $id)
    {
        $driver = $this->driverService->getById($id, $this->driverModel);
        if (!$driver) {
            return response([
                "message" => "Not Found",
            ], 404);
        }
        $user = $this->userModel::where('id', $driver->user_id)->first();
        $user->update($request->validated());
        $this->driverService->edit(
            $driver,
            $request->except(['driver_name', 'driver_image', 'image', 'name']) + [
                'image' => isset($request->validated()['driver_image']) ?? 'test.png',
                'name' => $request->validated()['driver_name'],
                'user_id' => $user->id
            ]
        );
        return response($driver);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $driver = $this->driverService->getById($id, $this->driverModel);
        if (!$driver) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->driverService->delete(
            $driver,
        );
        return response([
            "message" => "success",
        ]);
    }
}
