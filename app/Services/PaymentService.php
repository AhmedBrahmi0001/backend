<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

class PaymentService
{

    public function create(array $data, Payment $paymentModel): Payment
    {
        return $paymentModel::create($this->data($data));
    }


    public function edit(Payment $payment, array $data): void
    {
        $payment->update($this->data($data));
    }


    public function delete(Payment $payment): void
    {
        $payment->delete();
    }


    public function getById(int $id, Payment $paymentModel)
    {
        return $paymentModel::where('id', $id)->first();
    }

    public function getAll(Payment $paymentModel): Collection
    {
        return $paymentModel::all();
    }

    public function data($data): array
    {
        return
            [
                'order_id' => $data['order_id'],
                'amount' => $data['amount'],
                'status' => $data['status'],
                'payment_method' => $data['payment_method'],
                'payment_date' => $data['payment_date'],
            ];
    }
}
