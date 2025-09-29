<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'sometimes|required|string|max:255',
            'price'       => 'sometimes|required|numeric|min:0',
            'description' => 'nullable|string',
            'exp_date'    => 'nullable|date',
            'img_url'     => 'nullable|string',
            'quantity'    => 'nullable|integer|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',

            'discounts'   => 'array',
            'discounts.*.discount_date'      => 'required|date',
            'discounts.*.discount_percentage'=> 'required|numeric|min:0|max:100',
        ];
    }
}
