<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'price' => ['required', 'numeric'],
            'qty' => ['required', 'numeric'],
            'unit' => ['required', 'string'],
            'waybillTitle' =>  ['required', 'string'],
            'contractTitle' => ['required', 'string'],
            'date' => ['required'],
            'warehouseTitle' => ['required', 'string'],
            'vendorCode' => ['string'],
            'usedQty' => ['numeric'],
            'writtenOffQty' => ['numeric'],
            'providerId' => ['required'],
            'snippedUserId' => ['required'],
        ];
    }
}
