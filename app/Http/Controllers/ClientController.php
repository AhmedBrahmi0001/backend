<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\User;
use App\Services\ClientService;

class ClientController extends Controller
{

    public function __construct(
        private ClientService $clientService,
        private Client $clientModel,
        private User $userModel
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->clientModel::paginate(100);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $user = $this->userModel::create($request->validated());
        $client = $this->clientService->create(
            $request->validated() + [
                'user_id' => $user->id
            ],
            $this->clientModel,
        );

        return response($client);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $client = $this->clientService->getById($id, $this->clientModel);
        if (!$client) {
            return response([
                "message" => "Not Found",
            ], 404);
        }
        return response($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, int $id)
    {
        $client = $this->clientService->getById($id, $this->clientModel);
        if (!$client) {
            return response([
                "message" => "Not Found",
            ], 404);
        }
        $user = $this->userModel::find($client->user_id);
        $user->update($request->validated());
        // $this->clientService->edit(
        //     $client,
        //     $request->validated(),
        // );
        return response($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $client = $this->clientService->getById($id, $this->clientModel);
        if (!$client) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->clientService->delete(
            $client,
        );
        return response([
            "message" => "success",
        ]);
    }
}
