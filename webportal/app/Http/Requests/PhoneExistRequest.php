<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class PhoneExistRequest extends FormRequest
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
            'phone' => ['max:20'],
        ];
        
        // Phone
        if (config('settings.sms.phone_verification') == 1) {
            if ($this->filled('phone')) {
                $countryCode = $this->input('country_code', config('country.code'));
                if ($countryCode == 'UK') {
                    $countryCode = 'GB';
                }
                $rules['phone'][] = 'phone:' . $countryCode;
            }
        }
        if (isEnabledField('phone')) {
            $rules['phone'][] = 'required';
        }
        if ($this->filled('phone')) {
            $rules['phone'][] = 'unique:users,phone';
        }
        return $rules;
    }


    public function failedValidation($validator) {

        $failedRules = $validator->failed();
        
        if(isset($failedRules['phone']['Unique'])) {
            $json = [];
            $json['error'] = 1;
            $json['error_mess'] = t('The phone has already been taken.');
         }

         echo json_encode($json);
         exit();
     }

    // /**
    //  * Configure the validator instance.
    //  *
    //  * @param  \Illuminate\Validation\Validator  $validator
    //  * @return void
    //  */
    // public function withValidator($validator)
    // {
    //     $ret_arr = array(
    //         'success' => 0,
    //         'success_message' => '',
    //         'error' => 0,
    //         'error_message' => '',
    //     );

        
    //         $validator->after(function ($validator) {die('d');
    //             $failedRules = $validator->failed();print_r($failedRules);die;
    //             if(isset($failedRules['phone']['Unique'])) {
    //                 $validator = Validator::make(request()->all(), ['phone' => 'required']);
    //                 $validator->errors()->add('phone', t('This number is already registered to FoxiJobs.'));

    //                 $ret_arr['success'] = 1;
    //                 $ret_arr['success_message'] = $validator->errors();
    //             }else{
    //                 $ret_arr['error'] = 1;
    //                 $ret_arr['error_message'] = t('Number not exist');
    //             }//die('d');
    //         });
            
    //     echo json_encode($ret_arr);die;
    // }
}
