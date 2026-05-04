<?php

declare(strict_types=1);

namespace App\Flow\Enum;

enum FlowProcessingRuleSource: string
{
    case Input = 'Input';
    case Computed = 'Computed';
}
