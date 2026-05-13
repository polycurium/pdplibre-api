<?php

declare(strict_types=1);

namespace App\Directory\Enum;

enum EntityType: string
{
    case Public = 'Public';

    case PrivateVatRegistered = 'PrivateVatRegistered';
}
