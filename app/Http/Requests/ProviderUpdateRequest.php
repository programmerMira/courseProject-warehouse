<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProviderUpdateRequest extends FormRequest
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
            'phone' => ['required', 'string'],
            'code' => ['required', 'string'],
            'inn' => ['required'],
            'certificateNumber' => ['required', 'integer'],
            'adress' => ['required', 'string'],
        ];
    }
}
