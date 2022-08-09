<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class AddBusinessProduct extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'commision_value' => 'numeric|between:0,9999999999.99',
            'enabled' => 'required|boolean',
            'businesses' => 'array',
            'businesses.*' => 'integer|exists:businesses,id',
        ];
    }
}
