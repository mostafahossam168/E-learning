<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource(User::find($this->id)),
            'comment' => $this->pivot->comment,
            'rate' => $this->pivot->rate,
            'created_at' => $this->pivot->created_at->diffForHumans(),
        ];
    }
}