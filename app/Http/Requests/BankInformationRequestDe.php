<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankInformationRequestDe extends FormRequest
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
            'bank_name.required' => 'Bankname darf nicht leer sein',
            'bank_residence_country.required' => 'Bitte wählen Sie Bankland',
            'bank_acc_name.required' => 'Bankkontoname darf nicht leer sein',
            'bank_acc_num.required' => 'Kontonummer (IBAN) darf nicht leer sein',
            'swift_num.required' => 'Bank Swift Code darf nicht leer sein',
            'bank_address.required' => 'Bankadresse darf nicht leer sein',
            'bank_residence_state.required' => 'Bitte wählen Sie die Bundesland Provinz',
            'bank_residence_city.required' => 'Bitte wählen Sie Stadt',
            'bank_residence_code.required' => 'Die Postleitzahl darf nicht leer sein',
            
        ];
    }

}
