<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupCouncilRequest extends FormRequest
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
            'name' => 'required|min:6|max:255'
        ];
    }
        /**
     * Get the error messages for the defined validation rules.
     *
     * @return  array
     */
    public function messages()
    {
        return [
           'name.required' => 'Tên không được để trống',
           'name.min'      => 'Tên quá ngắn',
           'name.max'      => 'Tên quá dài'
        ];
    }
}
