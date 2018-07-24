<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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
            'phone_driver' => 'unique:driver,phone_driver',
            'number_license_driver' => 'unique:driver,number_license_driver',
            'type_driver' => 'required',
            'name_driver' => 'required',
        ];
    }
}
