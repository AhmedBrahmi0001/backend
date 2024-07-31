<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class OrderService
{

    public function create(array $data, Order $orderModel): Order
    {
        $data = $this->data($data);
        $data['code'] = $this->generateUniqueCode();
        $data['price'] = Driver::find($data['driver_id'])->price;
        return $orderModel::create($data);
    }


    public function edit(Order $order, array $data): void
    {
        $order->update($this->data($data));
    }


    public function delete(Order $order): void
    {
        $order->delete();
    }


    public function getById(int $id, Order $orderModel)
    {
       return $orderModel::with('client.user','driver')->where('id', $id)->first();
    }

    public function getAll(Order $orderModel): Collection
    {
        return $orderModel::all();
    }

    public function data($data): array
    {
        return
            [
                'driver_id' => $data['driver_id'],
                'client_id' => $data['client_id'],
                'pickup_address' => $data['pickup_address'],
                'deliver_address' => $data['deliver_address'],
                'quantity' => $data['quantity'],
                'description' => $data['description'],
                'longitude_deliver_address' => $data['longitude_deliver_address'],
                'latitude_deliver_address' => $data['latitude_deliver_address'],
                'longitude_pickup_address' => $data['longitude_pickup_address'],
                'latitude_pickup_address' => $data['latitude_pickup_address'],
            ];
    }

    public function generateUniqueCode()
    {
        do {
            $code = 'ORD' . Str::random(10);
        } while (Order::where('code', $code)->exists());

        return $code;
    }
}
