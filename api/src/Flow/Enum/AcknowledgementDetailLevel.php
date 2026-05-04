<?php

declare(strict_types=1);

namespace App\Flow\Enum;

enum AcknowledgementDetailLevel: string
{
    case Error = 'Error';
    case Warning = 'Warning';
}
