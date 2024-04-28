<?php
/**
 * Created by PhpStorm.
 * User: solom
 * Date: 7/14/2020
 * Time: 12:34 PM
 */

namespace App\Http\Requests;

use App\Company;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->action === 'register'){
            return [
                'name'                      => [
                    'required',
                    'string',
                    Rule::unique('companies', 'name')
                ],
                'sb_payment_no'             => 'required|digits:10',
                'phone'                     => 'required|numeric',
                'postcode'                  => 'required|numeric',
                'address'                   => 'required|string',
                'owner_name'                => 'required|string',
                'owner_mail'                => 'required|email',
                'login_id'                  => [
                    'required',
                    'string',
                    'min:4',
                    'max:18',
                    Rule::unique('users', 'login_id')
                ],
                'password'                  => 'required|min:4|max:18',
                'user_id',
            ];
        } else if($this->action === 'update'){
            return [
                'name'                      => [
                    'required',
                    'string',
                ],
                'sb_payment_no'             => 'required|digits:10',
                'phone'                     => 'required|numeric',
                'postcode'                  => 'required|numeric',
                'address'                   => 'required|string',
                'owner_name'                => 'required|string',
                'owner_mail'                => 'required|email',
                'login_id'                  => [
                    'required',
                    'string',
                    'min:4',
                    'max:18',
                ],
                'password'                  => 'min:4|max:18',
            ];
        }
    }

    public function validate()
    {
        return parent::validate();
    }

        public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if($this->action === 'update'){
                if($company = Company::query()->where('name', $this->name)->where('id', '!=', $this->id)->first()){
                    $validator->errors()->add('name', "Name already exist!");
                }

                if($user = User::query()->where('login_id', $this->login_id)->where('company_id', '!=', $this->id)->first()){
                    $validator->errors()->add('login_id', "Login Id already exists!");
                }
            }
        });
    }

    public function messages()
    {
        return [
            'name.required'                                  => 'Name is required',
            'name.unique'                                    => 'Name already exist',
            'phone.required'                                 => 'Phone is required',
            'phone.numeric'                                  => 'Phone Number must be digits',
            'postcode.required'                              => 'PostCode is required',
            'postcode.numeric'                               => 'PostCode must be digits',
            'address.required'                               => 'Address is required',
            'owner_name.required'                            => 'Owner Name is required',
            'owner_mail.required'                            => 'Owner Mail is required',
            'owner_mail.email'                               => 'Mail address is not invalid',
            'sb_payment_no.required'                         => 'Sb Payment No is required',
            'sb_payment_no.digits'                           => 'Sb Payment No must be 10 digits',
            'login_id.required'                              => 'Login Id is required',
            'login_id.min'                                   => 'Login Id must be more than 4 letters',
            'login_id.max'                                   => 'Login Id must be less than 18 letters',
            'login_id.unique'                                => 'Login Id already exists',
            'password.required'                              => 'Password is required',
            'password.min'                                   => 'Password must be more than 4 letters',
            'password.max'                                   => 'Password must be less than 18 letters',
        ];
    }
}
