<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|alpha',
            'middle_name' => ['nullable', 'max:2', 'regex:/^[A-Za-z](\.?)$/'],
            'last_name' => 'required|alpha',
            'email' => 'required|string|email|unique:users|max:255',
            'contact_number' => 'required|max:20',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
