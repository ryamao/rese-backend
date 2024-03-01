<?php

declare(strict_types=1);

namespace App\Types;

enum FavoriteStatus: string
{
    case Unknown = 'unknown';
    case Marked = 'marked';
    case Unmarked = 'unmarked';
}
