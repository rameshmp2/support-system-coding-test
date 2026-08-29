<?php

namespace App\Enums;

enum TicketStatus: string
{
    case New = 'new';
    case Opened = 'opened';
    case Replied = 'replied';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::New     => 'New',
            self::Opened  => 'Opened',
            self::Replied => 'Replied',
            self::Closed  => 'Closed',
        };
    }

    // for CSS badge class used in Blade.
    public function badge(): string
    {
        return match ($this) {
            self::New     => 'badge--new',
            self::Opened  => 'badge--opened',
            self::Replied => 'badge--replied',
            self::Closed  => 'badge--closed',
        };
    }
}
