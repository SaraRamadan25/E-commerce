<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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

            'mobile' => 'required|string|max:20',
            'address1' => 'required|string',
            'address2' => 'nullable|string',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',


        ];
    }
}
