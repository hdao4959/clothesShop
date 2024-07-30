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
            'name' => 'bail|required',
            'price_regular' => 'bail|required|numeric',
            'price_sale' => 'bail|nullable|numeric',

        ];
    }

    public function messages(){
        return [
            'name.required' => "Tên sản phẩm không được để trống",
            'price_regular.required' => 'Bạn chưa nhập giá cho sản phẩm',
            'price_regular.numeric' => "Giá sản phẩm không hợp lệ",
            'price_sale.numeric' => "Giá sản phẩm không hợp lệ"
        ];
    }
}
