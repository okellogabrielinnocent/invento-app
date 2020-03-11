<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is_admin() || auth()->user()->is_data_entrant();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'brand' => 'required|string',
            'cost' => 'required|integer',
            'size' => 'required|string',
            'minimum_quantity' => 'required|integer',
            'quantity' => 'required|integer'
        ];
    }
}
