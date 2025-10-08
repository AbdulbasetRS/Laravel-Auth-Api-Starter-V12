<?php

namespace App\Http\Requests\Auth;

use App\Exceptions\UnauthorizedCustomException;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identifier' => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'identifier.required' => 'The identifier field is required.',
            'identifier.string' => 'The identifier must be a string.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 6 characters.'
        ];
    }

    public function failedAuthorization() {
        throw new UnauthorizedCustomException();
    }
}
