<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{

    public function create(array $data, Notification $notificationModel): Notification
    {
        return $notificationModel::create($this->data($data));
    }


    public function edit(Notification $notification, array $data): void
    {
        $notification->update($this->data($data));
    }


    public function delete(Notification $notification): void
    {
        $notification->delete();
    }


    public function getById(int $id, Notification $notificationModel)
    {
        return $notificationModel::where('id', $id)->first();
    }

    public function getAll(Notification $notificationModel): Collection
    {
        return $notificationModel::all();
    }
    public function markNotificationAsRead($id)
    {
        $notification = Notification::where('id',$id)->first();
        $notification->update(['is_read' =>true]);
        return $notification;

    }
    public function markAllNotificationAsRead()
    {
        Notification::where('is_read',false)->update(['is_read'=>true]);
        return true;
    }

    public function data($data): array
    {
        return
            [

                'title' =>$data['title'],
                'description' =>$data['description'],
                'is_read' =>$data['is_read'],
                'user_id' => $data['user_id'],

            ];
    }
}
