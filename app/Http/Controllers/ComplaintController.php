<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;
use App\Services\ComplaintService;

class ComplaintController extends Controller
{ private Complaint $complaintModel;
    private ComplaintService $complaintService;

    public function __construct(ComplaintService $complaintService, Complaint $complaintModel)
    {
        $this->complaintService = $complaintService;
        $this->complaintModel = $complaintModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->complaintModel::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaintRequest $request)
    {
        $complaint = $this->complaintService->create(
            $request->validated(),
            $this->complaintModel,
        );

        return response($complaint);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $complaint = $this->complaintService->getById($id, $this->complaintModel);
        if (!$complaint) {
            return response([
                "message" => "Not Found",
            ], 404);
        }
        return response($complaint);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintRequest $request, int $id)
    {
        $complaint = $this->complaintService->getById($id, $this->complaintModel);
        if (!$complaint) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->complaintService->edit(
            $complaint,
            $request->validated(),
        );
        return response($complaint);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $complaint = $this->complaintService->getById($id, $this->complaintModel);
        if (!$complaint) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->complaintService->delete(
            $complaint,
        );
        return response([
            "message" => "success",
        ]);
    }
}
