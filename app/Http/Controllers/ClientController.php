<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\User;
use App\Services\ClientService;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    private User $ClientModel;
    private ClientService $ClientService;

    public function __construct(ClientService $ClientService, User $ClientModel)
    {
        $this->ClientService = $ClientService;
        $this->ClientModel = $ClientModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->ClientService->getAll($this->ClientModel);
    }

    public function store(StoreClientRequest $request)
    {
        try {
            $Client = $this->ClientService->create(
                $request->validated(),
                new Client()  // Pass a new Client instance to the service
            );
            return response($Client);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response([
                'message' => 'Failed to create Client.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $Client = $this->ClientService->getById($id, $this->ClientModel);
        if (!$Client) {
            return response([
                'message' => 'Not Found',
            ], 404);
        }
        return response($Client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, int $id)
    {
        $Client = $this->ClientService->getById($id, $this->ClientModel);
        if (!$Client) {
            return response([
                'message' => 'Not Found',
            ], 404);
        }

        $this->ClientService->edit(
            $Client,
            $request->validated()
        );
        return response($Client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $Client = $this->ClientService->getById($id, $this->ClientModel);
        if (!$Client) {
            return response([
                'message' => 'Not Found',
            ], 404);
        }

        $this->ClientService->delete($Client, $id);
        return response([
            'message' => 'success',
        ]);
    }
}
