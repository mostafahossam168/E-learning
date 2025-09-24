<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponeRequest extends FormRequest
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
                        'code' => 'required|unique:coupones,code|digits:6',
                        'course_id' => 'required|exists:courses,id',
                        'discount_type' => 'required|in:fixed,percentage',
                        'discount_value' => 'required',
                        'status' => 'required|boolean',
                        'usage_limit' => 'nullable|numeric',
                        'start_date' => 'required|date|before:end_date',
                        'end_date' => 'required|date|after:start_date'
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'code' => 'required|digits:6|unique:coupones,code,' . $this->coupone,
                        'course_id' => 'required|exists:courses,id',
                        'discount_type' => 'required|in:fixed,percentage',
                        'discount_value' => 'required',
                        'status' => 'required|boolean',
                        'usage_limit' => 'nullable|numeric',
                        'start_date' => 'required|date|before:end_date',
                        'end_date' => 'required|date|after:start_date'
                    ];
                }
            default:
                break;
        }
    }
}