<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\BlacklistDomainRule;
use App\Rules\BlacklistEmailRule;

class EmailExistRequest extends FormRequest
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
        $rules = [
            'email' => ['max:100', new BlacklistEmailRule(), new BlacklistDomainRule()],
        ];
        
        // Email
        if ($this->filled('email')) {
            $rules['email'][] = 'email';
            $rules['email'][] = 'unique:users,email';
        }
        if (isEnabledField('email')) {
            $rules['email'][] = 'required';
        }
        return $rules;
    }


    public function failedValidation($validator) {

        $failedRules = $validator->failed();
        
        if (isset($failedRules['email']['Unique'])) {
            $json = [];
            $json['error'] = 1;
            $json['error_mess'] = t('The email has already been taken.');
         }

         echo json_encode($json);
         exit();
     }
}
