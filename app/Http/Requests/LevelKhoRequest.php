<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LevelKhoRequest extends FormRequest
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
            'levelkho' => 'required|numeric|min:1|max:3',
            /*'time_upgrade_level' => 'required',*/
        ];
    }
}
