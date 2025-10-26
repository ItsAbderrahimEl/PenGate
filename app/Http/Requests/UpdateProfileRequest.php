<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                'min:5',
                "regex:/^[A-Za-z][A-Za-z.']*(?: [A-Za-z][A-Za-z.']*)+$/",
            ],
            'phone' => [
                'sometimes',
                'nullable',
                'string',
                'max:18',
                'min:8',
                "regex:/^\+?\d+(?:-\d+)*$/",
            ],
            'email' => [
                'sometimes',
                'required',
                'string',
                'email:strict',
                'max:50',
                'min:5',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'bio' => [
                'sometimes',
                'nullable',
                'string',
                'max:350',
                'min:5',
            ],
            'avatar' => [
                'sometimes',
                'nullable',
                'image',
                'max:2048',
                'mimes:jpeg,png,jpg',
                'mimetypes:image/jpeg,image/png,image/jpg',
            ],
            'current_password' => [
                'sometimes',
                'required',
                'string',
                'min:8',
                'max:100',
                'current_password',
                'exclude'
            ],
            'new_password' => [
                'sometimes',
                'required',
                'present_with:current_password',
                'string',
                'min:8',
                'max:100',
                'confirmed',
            ],
        ];
    }

    public function passedValidation(): void
    {
        if ($this->has('new_password')) {
            $this->merge([
                'password' => $this->input('new_password'),
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This email has already been taken.',
            'current_password.current_password' => 'The current password is incorrect.',
            'name.regex' => 'Please provide your complete name without numbers or special characters.',
            'new_password.confirmed' => 'The passwords do not match.',
            'avatar.image' => 'The avatar must be a valid image (JPEG or PNG).',
            'avatar.mimes' => 'The avatar must be a file of type: jpeg, jpg, png.',
            'avatar.max' => 'The avatar must be less than 2MB.'
        ];
    }
}
