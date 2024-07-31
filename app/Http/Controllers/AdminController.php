<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Services\AdminService;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{ private Admin $adminModel;
    private AdminService $adminService;

    public function __construct(AdminService $adminService, Admin $adminModel)
    {
        $this->adminService = $adminService;
        $this->adminModel = $adminModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->adminModel::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        try {
        $admin = $this->adminService->create(
            $request->validated(),
            $this->adminModel,
        );
        return response($admin);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $admin = $this->adminService->getById($id, $this->adminModel);
        if (!$admin) {
            return response([
                "message" => "Not Found",
            ], 404);
        }
        return response($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, int $id)
    {
        $admin = $this->adminService->getById($id, $this->adminModel);
        if (!$admin) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->adminService->edit(
            $admin,
            $request->validated(),
        );
        return response($admin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $admin = $this->adminService->getById($id, $this->adminModel);
        if (!$admin) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->adminService->delete(
            $admin,
        );
        return response([
            "message" => "success",
        ]);
    }
}
