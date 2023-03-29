<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'first_name' => 'required',
            'name' => 'required',
            'email' => 'required||unique:users,email,'.auth()->user()->id,
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Not a valid email adres',
        ];
    }
}
