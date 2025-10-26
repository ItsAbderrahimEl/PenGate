<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|max:255|min:3|string',
            'body' => 'required|max:4000|min:3|string',
            'topic_id' => 'required|numeric|integer|exists:topics,id'
        ];
    }

    public function messages(): array
    {
        return [
            'topic_id.number' => 'The topic id must be a number.',
            'topic_id.exists' => 'Choose a valid topic from the list.',
        ];
    }
}
