<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        // لاحقاً ممكن نضيف authorization logic (Policies)
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'exp_date'    => 'nullable|date',
            'img_url'     => 'nullable|string',
            'quantity'    => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',

            // إذا أردنا قبول خصومات مباشرةً
            'discounts'   => 'array',
            'discounts.*.discount_date'      => 'required|date',
            'discounts.*.discount_percentage'=> 'required|numeric|min:0|max:100',
        ];
    }
}
