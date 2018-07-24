<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required',
            'customer_id' => 'required',
            'type_pay' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'product_id.required'  => 'Vui lòng chọn sản phẩm',
            'customer_id.required'  => 'Vui lòng chọn khách hàng',
            'type_pay.required'  => 'Vui lòng chọn phương thức thanh toán'
        ];
    }
}
