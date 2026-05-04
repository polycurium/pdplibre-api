<?php

declare(strict_types=1);

namespace App\Flow\ValueObjects;

use App\Flow\Doctrine\Entity\AcknowledgementDetail;
use App\Flow\Enum\AcknowledgementDetailLevel;
use App\Flow\Enum\ReasonCode;

final readonly class AcknowledgementDetailOutput
{
    public function __construct(
        public AcknowledgementDetailLevel $level,
        public string $item,
        public ReasonCode|string $reasonCode,
        public string $reasonMessage,
    ) {
    }

    public static function fromEntity(AcknowledgementDetail $detail): self
    {
        return new self(
            level: $detail->getLevel(),
            item: $detail->getItem(),
            reasonCode: $detail->getReasonCode(),
            reasonMessage: $detail->getReasonMessage(),
        );
    }
}
