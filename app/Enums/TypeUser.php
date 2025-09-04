<?php

namespace App\Enums;

enum TypeUser: string
{
    case ADMIN = 'admin';
    case STUDENT = 'student';
    case TEACHER = 'teacher';


    public function name(): string
    {
        return match ($this) {
            Self::ADMIN => 'مشرف',
            Self::STUDENT => 'طالب',
            Self::TEACHER => 'معلم',
        };
    }
}