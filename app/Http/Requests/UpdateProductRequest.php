<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'status' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'required|exists:companies,id',
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
            'name' => 'اسم المنتج',
            'description' => 'الوصف',
            'image' => 'الصورة',
            'price' => 'السعر',
            'discount_price' => 'سعر الخصم',
            'stock' => 'الكمية المتوفرة',
            'status' => 'الحالة',
            'category_id' => 'الفئة',
            'company_id' => 'الشركة',
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
            'name.required' => 'اسم المنتج مطلوب',
            'name.max' => 'اسم المنتج يجب ألا يتجاوز 255 حرف',
            'description.required' => 'الوصف مطلوب',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب أن يكون رقم',
            'price.min' => 'السعر يجب أن يكون أكبر من أو يساوي صفر',
            'discount_price.numeric' => 'سعر الخصم يجب أن يكون رقم',
            'discount_price.min' => 'سعر الخصم يجب أن يكون أكبر من أو يساوي صفر',
            'discount_price.lt' => 'سعر الخصم يجب أن يكون أقل من السعر الأصلي',
            'stock.required' => 'الكمية المتوفرة مطلوبة',
            'stock.integer' => 'الكمية المتوفرة يجب أن تكون رقم صحيح',
            'stock.min' => 'الكمية المتوفرة يجب أن تكون أكبر من أو تساوي صفر',
            'category_id.required' => 'الفئة مطلوبة',
            'category_id.exists' => 'الفئة المحددة غير موجودة',
            'company_id.required' => 'الشركة مطلوبة',
            'company_id.exists' => 'الشركة المحددة غير موجودة',
            'image.image' => 'يجب أن يكون الملف صورة',
            'image.mimes' => 'يجب أن تكون الصورة بصيغة: jpeg, png, jpg, gif',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
        ];
    }
}
