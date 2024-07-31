<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    private Payment $paymentModel;
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService, Payment $paymentModel)
    {
        $this->paymentService = $paymentService;
        $this->paymentModel = $paymentModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->paymentModel::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $payment = $this->paymentService->create(
            $request->validated(),
            $this->paymentModel,
        );

        return response($payment);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $payment = $this->paymentService->getById($id, $this->paymentModel);
        if (!$payment) {
            return response([
                "message" => "Not Found",
            ], 404);
        }
        return response($payment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, int $id)
    {
        $payment = $this->paymentService->getById($id, $this->paymentModel);
        if (!$payment) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->paymentService->edit(
            $payment,
            $request->validated(),
        );
        return response($payment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $payment = $this->paymentService->getById($id, $this->paymentModel);
        if (!$payment) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->paymentService->delete(
            $payment,
        );
        return response([
            "message" => "success",
        ]);
    }
}
