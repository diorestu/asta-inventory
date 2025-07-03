<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'name' => 'required|string|max:160',
            'contact_person' => 'nullable|string|max:160',
            'email' => 'nullable|string|max:100',
            'phone_number' => 'required|string|max:30',
            'tax_id' => 'nullable|string|max:20',
            'city' => 'required|string|max:160',
            'country' => 'required|string|max:160',
            'address' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'payment_terms' => 'nullable|string',

        ];
    }
}
