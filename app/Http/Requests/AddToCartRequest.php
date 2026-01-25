<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;

class AddToCartRequest extends FormRequest
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
            'product_id' => [
                'required',
                'exists:products,id',
                function ($attribute, $value, $fail) {
                    $product = Product::find($value);
                    
                    if (!$product || !$product->status) {
                        $fail('المنتج غير متوفر');
                    }
                    
                    if ($product && $product->stock <= 0) {
                        $fail('المنتج غير متوفر في المخزون');
                    }
                },
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $productId = $this->input('product_id');
                    $product = Product::find($productId);
                    
                    if ($product && $value > $product->stock) {
                        $fail('الكمية المطلوبة أكبر من المتوفر في المخزون');
                    }
                },
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'product_id' => 'المنتج',
            'quantity' => 'الكمية',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'المنتج مطلوب',
            'product_id.exists' => 'المنتج غير موجود',
            'quantity.required' => 'الكمية مطلوبة',
            'quantity.integer' => 'الكمية يجب أن تكون رقم صحيح',
            'quantity.min' => 'الكمية يجب أن تكون على الأقل 1',
        ];
    }
}
