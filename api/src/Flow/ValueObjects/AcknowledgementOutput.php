<?php

declare(strict_types=1);

namespace App\Flow\ValueObjects;

use App\Flow\Doctrine\Entity\Acknowledgement;
use App\Flow\Enum\FlowAckStatus;

final readonly class AcknowledgementOutput
{
    /**
     * @param array<AcknowledgementDetailOutput> $details
     */
    public function __construct(
        public FlowAckStatus $status,
        public array $details,
    ) {
    }

    public static function fromEntity(Acknowledgement $ack): self
    {
        return new self(
            status: $ack->getStatus(),
            details: array_map(
                AcknowledgementDetailOutput::fromEntity(...),
                $ack->getDetails()->toArray(),
            ),
        );
    }
}
