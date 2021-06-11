<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
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
            'station' => 'required|string|max:150|unique:devices,station,'.$this->id,
            'datalogger' => 'required|string|max:30',
            'coordinates' => 'required|string|max:100',
            'remarks' => 'required|string',
            'status' => 'required|integer',
            'municipality' => 'required|integer',
            'type' => 'required|integer'
        ];
    }

    public function messages()
    {
        $message =  [
            'station.required' => '* required',
            'datalogger.required' => '* required',
            'coordinates.required' => '* required',
            'remarks.required' => '* required',
            'status.required' => '* required',
            'municipality.required' => '* required',
            'type.required' => '* required',
        ];

        return $message;
    }
}
