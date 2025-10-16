<?php

namespace App\Enums;

enum TypeMessage: string
{
    case TEXT = 'text';
    case IMAGE = 'image';
    case FILE = 'file';


    public function name(): string
    {
        return match ($this) {
            Self::TEXT => 'نص',
            Self::IMAGE => 'صوره',
            Self::FILE => 'ملف',
        };
    }
}
