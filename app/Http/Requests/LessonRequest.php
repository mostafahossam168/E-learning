<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
                        'title' => 'required|max:255',
                        'course_id' => 'required|exists:courses,id',
                        'status' => 'required|boolean',
                        'video_url' => 'required|mimes:mp4,avi,mkv|max:102400',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'title' => 'required|max:255',
                        'course_id' => 'required|exists:courses,id',
                        'status' => 'required|boolean',
                        'video_url' => 'nullable|mimes:mp4,avi,mkv|max:102400',
                    ];
                }
            default:
                break;
        }
    }
}
