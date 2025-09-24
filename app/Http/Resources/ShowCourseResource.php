<?php

namespace App\Http\Resources;

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
            'description' => $this->description,
            'status' => $this->status->name(),
            'cover' => $this->cover ? display_file($this->cover) : null,
            'number_lessons' => $this->lessons()->count(),
            'lessons' => LessonResource::collection($this->lessons),
            'rate' => $this->reviews()->avg('rate'),
            'reviews' => ReviewResource::collection($this->reviews),
            'duration' => $this->lessons->sum('duration'),
            'is_favorite' => auth()->user()->favorites->contains($this->id),
            'is_enrollment' => auth()->user()->studentCourses->contains($this->id),
        ];
    }
}