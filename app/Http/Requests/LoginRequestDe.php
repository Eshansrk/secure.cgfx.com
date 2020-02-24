<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequestDe extends FormRequest
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
            
            "email" => "required|email",
            "password" => "required"
        ];
    }

    // custom validation message
    public function messages()
    {
        return [

        "email.required" => "Bitte geben Sie E-Mail ein",
        "password.required" => "Passwortfeld ist erforderlich",

        ];
    }
}
