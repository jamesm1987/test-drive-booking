<?php

namespace App\Enums;

enum AttributeSelectType: string {
    case SINGLE = 'Single';
    case MULTI = 'Multi';

    public function label(): string
    {
        return match ($this) {
            self::SINGLE => 'Single',
            self::MULTI => 'Multi',
        };
    }
}