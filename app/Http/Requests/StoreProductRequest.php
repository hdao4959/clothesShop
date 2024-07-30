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
            'name' => 'bail|required',
            'category_id' => 'bail|required',
            'img_thumbnail' => 'bail|required|file|image',
            'price_regular' => 'bail|required|numeric',
            'price_sale' => 'bail|nullable|numeric',

        ];
    }

    public function messages(){
        return [
            'name.required' => "Tên sản phẩm không được để trống",
            'category_id.required' => "Bạn chưa chọn danh mục sản phẩm",
            'img_thumbnail.required' => "Bạn chưa chọn hình ảnh sản phẩm",
            'img_thumbnail.image' => "Hình ảnh không hợp lệ",
            'price_regular.required' => 'Bạn chưa nhập giá cho sản phẩm',
            'price_regular.numeric' => "Giá sản phẩm không hợp lệ",
            'price_sale.numeric' => "Giá sản phẩm không hợp lệ"
        ];
    }
}
