<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:150|unique:users,email,'.$this->id,
            'member' => 'required|integer',
            'municipality' => 'required|integer',
            'avatar' => 'nullable|image64:jpeg,jpg,png',
        ];
    }
}
