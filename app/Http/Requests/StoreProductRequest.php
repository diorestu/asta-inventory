<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'cat_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:product_units,id',
            'name' => 'required|string|max:255',
            'slug' => 'string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'description' => 'nullable|string',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'nullable|integer|gte:min_stock', // gte: greater than or equal to min_stock
        ];
    }
}
