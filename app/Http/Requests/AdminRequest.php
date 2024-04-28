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

class AdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->action === 'register'){
            return [
                'login_id'                      => [
                    'required',
                    'min:4',
                    'max:18',
                    Rule::unique('users', 'login_id')
                ],
                'name'                          => 'required|string|max:255',
                'password'                      => 'required|min:4|max:18',
                'password_confirmation'         => 'required',
            ];
        } else if($this->action === 'update'){
            return [
                'login_id'                      => [
                    'required',
                    'min:4',
                    'max:18',
                ],
                'name'                          => 'required|string|max:255',
                'password'                      => 'min:4|max:18',
            ];
        }

    }

    public function validate()
    {
        return parent::validate();
    }

    public function withValidator($validator){
        $validator->after(function ($validator){
            if($this->action === 'register'){

                if($this->password !== $this->password_confirmation){
                    $validator->errors()->add('password_confirmation', 'Confirm doesn`t match!');
                }
            }

            // if($this->action === 'update'){
            //     if(User::query()->where(['login_id' => $this->login_id])->where('name', '!=', $this->name)->first()){
            //         $validator->errors()->add('login_id', 'Login ID already exists!');
            //     }
            // }
            
            // if($this->action === 'update'){
            //     if(User::query()->where(['login_id' => $this->login_id])->first()->id != $this->id){
            //         $validator->errors()->add('login_id', 'Login ID already exists!');
            //     }
            // }
        });
    }

    public function messages()
    {
        return [
            'name.required'                                  => 'Name is required',
            'name.string'                                    => 'Name must be letters',
            'login_id.required'                              => 'Login Id is required',
            'login_id.string'                                => 'Login Id must be letters!',
            'login_id.min'                                   => 'Login Id must be more than 4 letters',
            'login_id.max'                                   => 'Login Id must be less than 18 letters',
            'login_id.unique'                                => 'Login Id already exists',
            'password.required'                              => 'Password is required',
            'password.min'                                   => 'Password must be more than 4 letters',
            'password.max'                                   => 'Password must be less than 18 letters',
            'password_confirmation.required'                 => 'Confirm is required',
        ];
    }
}
