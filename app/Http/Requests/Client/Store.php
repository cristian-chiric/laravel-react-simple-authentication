<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'profile_picture' => 'nullable|image|max:1024'
        ];
    }

    public function messages()
    {
        return [
            'profile_picture.max' => 'The profile picture size exceeded. Maximum allowed is 1 MB.'
        ];
    }
}
