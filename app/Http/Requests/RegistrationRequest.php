<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            //
            "first_name" => "required|string|max:50",
            "last_name" => "required|string|max:50",
            "email" => "required|string|email|max:100|unique:users,email",
            "phone_number" => "required|string|max:50",
            "business_name" => "required|string|max:100",
            "business_address" => "required|string|max:500",
            "business_email" => "required|string|email|max:100|unique:businesses,email",
            "business_phone_number" => "required|string|max:50",
        ];
    }
}
