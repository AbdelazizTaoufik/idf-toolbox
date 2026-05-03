<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',  // At least one uppercase
                'regex:/[0-9]/',  // At least one number
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'password.regex' => 'Das Passwort muss mindestens einen Großbuchstaben und eine Zahl enthalten.',
            'password.min' => 'Das Passwort muss mindestens 8 Zeichen lang sein.',
            'name.required' => 'Der Name ist erforderlich.',
            'email.required' => 'Die Email-Adresse ist erforderlich.',
            'email.unique' => 'Diese Email-Adresse ist bereits registriert.',
        ];
    }
}
