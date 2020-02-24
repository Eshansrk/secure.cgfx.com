<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankInformationRequest extends FormRequest
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
            'bank_acc_name' => 'required',
            'bank_acc_num' => 'required',
            'bank_name' => 'required',
            'bank_residence_country' => 'required',
            'bank_residence_state' => 'required',
            'bank_residence_city' => 'required',
            'bank_residence_code' => 'required',                       
            'swift_num' => 'required',
            'bank_address' => 'required'            
        ];
    }

    /**
 * Get the error messages for the defined validation rules.
 *
 * @return array
 */
    public function messages()
    {
        return [
            'bank_name.required' => 'Bank Name cannot be empty',
            'bank_residence_country.required' => 'Please select Bank Country',
            'bank_acc_name.required' => 'Bank Account Name cannot be empty',
            'bank_acc_num.required' => 'Account No (IBAN) cannot be empty',
            'swift_num.required' => 'Bank Swift Code cannot be empty',
            'bank_address.required' => 'Bank Address cannot be empty',
            'bank_residence_state.required' => 'Please select State Province',
            'bank_residence_city.required' => 'Please select City',
            'bank_residence_code.required' => 'Postal Code cannot be empty',
            
        ];
    }

}
