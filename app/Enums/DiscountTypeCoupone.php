<?php

namespace App\Enums;

enum DiscountTypeCoupone: string
{
    case PERCENTAGE = 'percentage';
    case FIXED = 'fixed';

    public function name(): string
    {
        return match ($this) {
            Self::PERCENTAGE => 'نسبه',
            Self::FIXED => 'قيمه ثابته',
        };
    }

    public function color(): string
    {
        return match ($this) {
            Self::PERCENTAGE => 'bg-primary',
            Self::FIXED =>  'bg-warning',
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}