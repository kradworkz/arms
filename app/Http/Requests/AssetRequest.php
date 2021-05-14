<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
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
            'name' => 'required|string|max:150|unique:assets,name,'.$this->id,
            'category' => 'required|integer',
            'avatar' => 'nullable|image64:jpeg,jpg',
            'brand' => 'nullable|string|max:150',
            'serial_no' => 'nullable|string|max:150',
            'model' => 'nullable|string|max:150',
            'desc' => 'nullable|string',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => '* required',
            'category.required' => '* required',
        ];
    }
}
