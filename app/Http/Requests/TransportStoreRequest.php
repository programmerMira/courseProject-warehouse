<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransportStoreRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'creationDate' => ['required'],
            'commissioningDate' => ['required'],
            'detailsUpdateDate' => ['required'],
            'number' => ['required', 'string', 'unique:transports,number'],
            'typeId' => ['required'],
            'brand' => ['required', 'string'],
            'model' => ['required', 'string'],
            'chassis_engine_number' => ['required', 'string'],
            'engine_volume' => ['required'],
            'weight' => ['required'],
            'color' => ['required', 'string'],
            'certificate' => ['required', 'string'],
            'factory_number' => ['required', 'string'],
            'rent' => ['required']
        ];
    }
}
