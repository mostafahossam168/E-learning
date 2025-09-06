<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CourseTableSeeder;
use Database\Seeders\LessonTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            PermissionTableSeeder::class,
            CategoryTableSeeder::class,
            CourseTableSeeder::class,
            LessonTableSeeder::class,
        ]);
    }
}