<?php

namespace App\Enums\RequestQuote;

enum RequestQuoteStatusEnum: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';

    public function name(): string
    {
        return match($this) {
            self::NEW => 'New',
            self::IN_PROGRESS => 'In Progress',
            self::DONE => 'Done',
        };
    }
}
