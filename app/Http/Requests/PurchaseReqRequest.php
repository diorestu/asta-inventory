<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseReqRequest extends FormRequest
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
            'request_date' => 'required|string|max:255',
            'purpose' => 'nullable|string',
            'item_id' => 'nullable|array',
            'item_name' => 'nullable|array',
            'qty' => 'nullable|array',
            'satuan' => 'nullable|array',
            'price' => 'nullable|array',
        ];
    }
}
