<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'delivered_date' => ['required', 'date'],
            'pickup_address' => ['required', 'string', 'max:255'],
            'deliver_address' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer'],
            'latitude_pickup_address' => ['required', 'string', 'max:255'],
            'longitude_pickup_address' => ['required', 'string', 'max:255'],
            'latitude_deliver_address' => ['required', 'string', 'max:255'],
            'longitude_deliver_address' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'client_id' => ['required', 'exists:clients,id'],
            'driver_id' => ['required', 'exists:drivers,id'],
        ];
    }
}
