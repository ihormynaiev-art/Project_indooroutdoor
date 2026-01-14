<?php

namespace App\Enums\License;

enum LicenseStatusEnum: string
{
    case EMPTY = 'empty';
    case IN_REVIEW = 'in_review';
    case APPROVED = 'approved';

    public function name(): string
    {
        return match ($this) {
            self::EMPTY => 'Empty',
            self::IN_REVIEW => 'In Review',
            self::APPROVED => 'Approved',
        };
    }
}
