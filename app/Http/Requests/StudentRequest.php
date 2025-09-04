<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
                        'image' => 'nullable|image|mimes:png,jpg',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name' => 'required|string|max:255',
                        'email' => "required|email|unique:users,email," . $this->student,
                        'phone' => "required|numeric|unique:users,phone," . $this->student,
                        'status' => 'required|boolean',
                        'password' => 'nullable|min:4|confirmed',
                        'image' => 'nullable|image|mimes:png,jpg',
                    ];
                }
            default:
                break;
        }
    }
}