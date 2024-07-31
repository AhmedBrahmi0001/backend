<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;


class NotificationController extends Controller
{  private Notification $notificationModel;
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService, Notification $notificationModel)
    {
        $this->notificationService = $notificationService;
        $this->notificationModel = $notificationModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->notificationModel::paginate(10);
    }
    public function MarkAsRead($id)
    {
        return response()->json($this->notificationService->markNotificationAsRead($id));
    }
    public function MarkAllAsRead()
    {
        return $result= $this->notificationService->markAllNotificationAsRead();
        return response()->json(['message' => 'All notifications marked as read', 'success' => $result]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationRequest $request)
    {
        $notification = $this->notificationService->create(
            $request->validated(),
            $this->notificationModel,
        );

        return response($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
         Log::info('Notification ID type:', ['type' => gettype($id), 'value' => $id]);

        $notification = $this->notificationService->getById($id, $this->notificationModel);
        if (!$notification) {
            return response([
                "message" => "Not Found",
            ], 404);
        }
        return response($notification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationRequest $request, int $id)
    {
        $notification = $this->notificationService->getById($id, $this->notificationModel);
        if (!$notification) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->notificationService->edit(
            $notification,
            $request->validated(),
        );
        return response($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $notification = $this->notificationService->getById($id, $this->notificationModel);
        if (!$notification) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->notificationService->delete(
            $notification,
        );
        return response([
            "message" => "success",
        ]);
    }
}
