<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'min:5',
                'regex:/^[a-zA-Z]+( [a-zA-Z]+)+$/'
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::default()
            ],
            'email' => [
                'required',
                'string',
                'email:strict',
                'max:100',
                'min:5',
                'unique:users,email'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password' => 'This password has been compromised, change it please.',
            'name.regex' => 'The name must contain only letters, and include your full name.'
        ];
    }
}
