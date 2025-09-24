<?php

namespace App\Enums;

enum StatusReview: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;

    public function name(): string
    {
        return match ($this) {
            Self::ACTIVE => 'مفعل',
            Self::INACTIVE => 'غير مفعل',
        };
    }
    public function color(): string
    {
        return match ($this) {
            Self::ACTIVE => 'bg-success',
            Self::INACTIVE =>  'bg-danger',
        };
    }


    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}