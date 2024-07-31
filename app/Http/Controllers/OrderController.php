<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private Order $orderModel;
    private OrderService $orderService;

    public function __construct(OrderService $orderService, Order $orderModel)
    {
        $this->orderService = $orderService;
        $this->orderModel = $orderModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->orderModel::paginate(10000);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->create(
            $request->validated(),
            $this->orderModel,
        );

        return response($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $order = $this->orderService->getById($id, $this->orderModel);
        if (!$order) {
            return response([
                "message" => "Not Found",
            ], 404);
        }
        return response($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, int $id)
    {
        $order = $this->orderService->getById($id, $this->orderModel);
        if (!$order) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->orderService->edit(
            $order,
            $request->validated(),
        );
        return response($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $order = $this->orderService->getById($id, $this->orderModel);
        if (!$order) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->orderService->delete(
            $order
        );
        return response([
            "message" => "success",
        ]);
    }
    public function sendOrderPosition(Request $request, Order $order){
        $this->validate($request,[
            'latitude_actuelle' => 'required',
            'longitude_actuelle' => 'required',
        ]);
        $order->latitude_actuelle = $request->latitude_actuelle;
        $order->longitude_actuelle = $request->longitude_actuelle;
        $order->save();
        return response()->json(['message' => 'The postion update successufuly'],200);
    }
}
