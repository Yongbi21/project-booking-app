<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:255|alpha',
            'middle_name' => ['nullable', 'max:2', 'regex:/^[A-Za-z](\.?)$/'],
            'last_name' => 'required|max:255|alpha',
            'contact_number' => 'nullable|max:20',
            'email' => 'required|email|max:255',
        ];
    }
}
