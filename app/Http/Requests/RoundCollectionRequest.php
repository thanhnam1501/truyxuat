<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoundCollectionRequest extends FormRequest
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
            'name' => 'required|min:3|max:255',
            'year' => 'required|date_format:"Y"|max:4|min:4',
            'expiration_time' => 'required|date_format:"Y-m-d H:i:s"',
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
           'name.max'      => 'Tên quá dài',
           'year.required'         => 'Năm không được để trống',
           'year.date_format'              => 'Năm không đúng định dạng',
           'year.min'      => 'Yêu cầu nhập đúng năm',
           'year.max'      => 'Yêu cầu nhập đúng năm',
           'expiration_time.required'              => 'Thời hạn không được để trống',
           'expiration_time.date_format'           => 'Thời hạn không đúng định dạng',
        ];
    }
}
