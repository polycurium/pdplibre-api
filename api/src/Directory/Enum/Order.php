<?php

declare(strict_types=1);

namespace App\Directory\Enum;

enum Order: string
{
    case ascending = 'ascending';
    case descending = 'descending';
}
