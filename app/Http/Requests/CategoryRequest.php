<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                        'name' => 'required|unique:categories,name',
                        'parent_id' => 'nullable|exists:categories,id',
                        'status' => 'required|boolean'
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name' => 'required|unique:categories,name,' . $this->category,
                        'parent_id' => 'nullable|exists:categories,id',
                        'status' => 'required|boolean'
                    ];
                }
            default:
                break;
        }
    }
}