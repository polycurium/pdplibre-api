<?php

declare(strict_types=1);

namespace App\Flow\Validation;

use App\Flow\Enum\AcknowledgementDetailLevel;
use App\Flow\Enum\ReasonCode;

final readonly class FlowValidationResultItem
{
    public function __construct(
        public AcknowledgementDetailLevel $level,
        public string $item,
        public ReasonCode|string $reasonCode,
        public string $reasonMessage,
    ) {
    }
}
