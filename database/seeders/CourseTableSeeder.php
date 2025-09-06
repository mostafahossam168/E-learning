<?php

namespace Database\Seeders;

use App\Enums\TypeUser;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'title' => fake()->name(),
            'description' => fake()->paragraph(),
            'price' => fake()->randomDigit(20, 200),
            'cover' => fake()->url(),
            'category_id' => Category::first()->id,
            'teacher_id' => User::where('type', TypeUser::TEACHER)->first()->id,
        ]);
    }
}
