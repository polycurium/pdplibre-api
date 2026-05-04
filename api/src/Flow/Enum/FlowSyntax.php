<?php

declare(strict_types=1);

namespace App\Flow\Enum;

enum FlowSyntax: string
{
    case CII = 'CII';
    case UBL = 'UBL';
    case FACTUR_X = 'Factur-X';
    case CDAR = 'CDAR';
    case FRR = 'FRR';
}
