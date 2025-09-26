<?php

namespace App\Http\Resources;

use App\Enums\StatusLesson;
use App\Enums\StatusReview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'teacher' => $this->teacher?->name,
            'category' => $this->category?->name,
            'status' => $this->status->name(),
            'cover' => $this->cover ? display_file($this->cover) : null,
            'description' => $this->description,
            'number_lessons' => $this->lessons()->where('status', StatusLesson::ACTIVE->value)->count(),
            'lessons' => LessonResource::collection($this->lessons()->where('status', StatusLesson::ACTIVE->value)->get()),
            'duration' => $this->lessons()->where('status', StatusLesson::ACTIVE->value)->sum('duration'),
            'reviews' => ReviewResource::collection($this->reviews()->wherePivot('status', 1)->get()),
            'rating' => $this->reviews()->wherePivot('status', 1)->avg('rate'),
            'enrollments' => $this->students()->count(),
            'is_enrollment' => auth()->user()->studentCourses()->exists($this->id),
            'is_favorite' => auth()->user()->favorites()->exists($this->id),
        ];
    }
}