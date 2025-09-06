<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
                        'title' => 'required|unique:courses,title|max:255',
                        'category_id' => 'required|exists:categories,id',
                        'teacher_id' => 'required|exists:users,id',
                        'status' => 'required|boolean',
                        'cover' => 'required|image',
                        'price' => 'required|numeric',
                        'description' => 'required|string',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'title' => 'required|max:255|unique:courses,title,' . $this->course,
                        'category_id' => 'required|exists:categories,id',
                        'teacher_id' => 'required|exists:users,id',
                        'status' => 'required|boolean',
                        'cover' => 'nullable|image',
                        'price' => 'required|numeric',
                        'description' => 'required|string',
                    ];
                }
            default:
                break;
        }
    }
}