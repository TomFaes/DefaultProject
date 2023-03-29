<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ];
    }
    public function message(){
        return [
            'password.required' => 'Password is required',
            'password.min' => 'Password needs atleast 6 characters',
            'confirm_password.required' => 'You need to repeat the password',
            'confirm_password.same' => 'The password is not the same',
        ];
    }
}
