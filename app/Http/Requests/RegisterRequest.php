<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class RegisterRequest extends FormRequest
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
            'full_name' => 'required',
             'email' => 'required|email|unique:users',
            'gender' => 'required',
            'phone_no' => 'required|digits:10',
            'role' => 'required',
            'password' => 'required|min:6|required_with:re_password|same:re_password',
            're_password' => 'required|min:6',
            
           
        ];
    }
}
