<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'amount' => ['required', 'numeric', 'between:0,999999.99'],
            'payment_method' => ['required', 'string' ],
            'status' => ['required', 'string' ],
            'payment_date' => ['required', 'string' ],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
