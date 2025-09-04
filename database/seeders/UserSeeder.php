<?php

namespace Database\Seeders;

use App\Enums\TypeUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '123456789',
            'type' => TypeUser::ADMIN,
            'password' => Hash::make("123456"),
        ]);
        User::factory()->create([
            'name' => 'Student',
            'email' => 'student@student.com',
            'phone' => '1234567890',
            'type' => TypeUser::STUDENT,
            'password' => Hash::make("123456"),
        ]);
        User::factory()->create([
            'name' => 'Teacher',
            'email' => 'teacher@teacher.com',
            'phone' => '1234567899',
            'type' => TypeUser::TEACHER,
            'password' => bcrypt("123456"),
        ]);
    }
}