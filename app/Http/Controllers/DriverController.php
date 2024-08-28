<?php

namespace App\Http\Controllers;

use App\Helpers\GeneraleHelper;
use App\Models\Driver;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Http\Resources\DriverResource;
use App\Mail\DriverPasswordMail;
use App\Models\User;
use App\Services\DriverService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DriverController extends Controller
{
    private User $driverModel;
    private DriverService $driverService;

    public function __construct(DriverService $driverService, User $driverModel)
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
        $collections = $this->driverService->getAll($this->driverModel, $filters);
        return DriverResource::collection($collections);
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

        $driverData = $request->all();
        if($request->driver_image){
            $driverData['driver_image'] = GeneraleHelper::uploadFile($request, 'driver_images', 'driver_image');
        }
        if($request->image){
            $driverData['image'] = GeneraleHelper::uploadFile($request, 'user_images', 'image');
        }

        $driver = $this->driverService->create($driverData,
            new Driver(),
        );
        Mail::to($driver->user->email)->send(new DriverPasswordMail($driver, $driverData['password']));

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
        return response(new DriverResource($driver));
    }

    public function update(UpdateDriverRequest $request, int $id)
    {
        // Fetch the Driver model
        $driver = Driver::find($id);

        if (!$driver) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        // Handle file uploads
        $driverData = json_decode($request->getContent(), true);

        $driverData['driver_image'] = GeneraleHelper::uploadFile($request, 'driver_images', 'driver_image');
        $driverData['image'] = GeneraleHelper::uploadFile($request, 'user_images', 'image');

        // Update the Driver model with validated data
        $driver->update($driverData);

        // Update the associated User model
        $this->driverService->edit(
            $driver, // Pass the Driver model
            $request->except(['driver_name', 'driver_image', 'image', 'name']) + [
                'image' => isset($driverData['driver_image']) ? $driverData['driver_image'] : $driver->user->image,
                'name' => $driverData['driver_name'],
            ]
        );

        return response($driver->load('user'));
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
