<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST': {
                    return [
                        'name' => 'required|string|max:255',
                        'email' => 'required|email|unique:users,email',
                        'phone' => 'required|numeric|unique:users,phone',
                        'status' => 'required|boolean',
                        'password' => 'required|confirmed|string|min:4',
                        'role' => 'nullable|required|exists:roles,name',
                        'image' => 'nullable|image|mimes:png,jpg',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name' => 'required|string|max:255',
                        'email' => "required|email|unique:users,email," . $this->admin,
                        'phone' => "required|numeric|unique:users,phone," . $this->admin,
                        'status' => 'required|boolean',
                        'password' => 'nullable|min:4|confirmed',
                        'role' => 'nullable|required|exists:roles,name',
                        'image' => 'nullable|image|mimes:png,jpg',
                    ];
                }
            default:
                break;
        }
    }
}
