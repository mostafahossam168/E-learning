<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lesson::create([
            'title' => fake()->name(),
            'video_url' => fake()->url(),
            'duration' => fake()->randomDigit(),
            'course_id' => Course::first()->id,
        ]);
    }
}