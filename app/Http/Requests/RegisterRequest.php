<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', 'string', 'unique:users,phone', 'regex:/^(?:\+20|0)?1[0125][0-9]{8}$/'],
            'image' => 'nullable|image|mimes:png,jpg|max:1024',
            'token' => 'required|string',
            'password' => 'required|string|min:4|confirmed',
        ];
    }
}
