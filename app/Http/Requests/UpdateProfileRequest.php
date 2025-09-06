<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => ['required', 'string', 'unique:users,phone,' . auth()->id(), 'regex:/^(?:\+20|0)?1[0125][0-9]{8}$/'],
            'image' => 'nullable|image|mimes:png,jpg|max:1024',
            'password' => 'nullable|string|min:4|confirmed',
        ];
    }
}
