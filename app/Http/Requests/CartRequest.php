<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'single_item_price' => 'required|integer',
            'total_price' => 'required|integer',
            'quantity' => 'required|integer',
            'checkout_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
    }
}
