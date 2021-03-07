<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailsCardUpdateRequest extends FormRequest
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
            'date' => ['required'],
            'document' => ['required', 'string'],
            'qty' => ['required', 'numeric'],
            'unit' => ['required', 'string'],
            'productId' => ['required'],
            'transportId' => ['required'],
        ];
    }
}
