<?php

declare(strict_types=1);

namespace App\Flow\Validation;

use App\Flow\Doctrine\Entity\Acknowledgement;
use App\Flow\Doctrine\Entity\AcknowledgementDetail;
use App\Flow\Enum\AcknowledgementDetailLevel;
use App\Flow\Enum\ReasonCode;

final readonly class FlowValidationResults
{
    /** @param FlowValidationResultItem[] $results */
    public function __construct(
        public array $results = [],
    ) {
    }

    public function hasErrors(): bool
    {
        return array_any($this->results, static fn ($result) => AcknowledgementDetailLevel::Error === $result->level);
    }

    public function withError(string $item, ReasonCode|string $reason, string $message): self
    {
        return new self([...$this->results, new FlowValidationResultItem(AcknowledgementDetailLevel::Error, $item, $reason, $message)]);
    }

    public function mergeWith(self $other): self
    {
        return new self([...$this->results, ...$other->results]);
    }

    /**
     * @return array<AcknowledgementDetail>
     */
    public function asAcknowledgementDetails(Acknowledgement $baseAcknowledgment): array
    {
        $details = [];

        foreach ($this->results as $result) {
            $details[] = new AcknowledgementDetail(
                acknowledgement: $baseAcknowledgment,
                level: $result->level,
                item: $result->item,
                reasonCode: $result->reasonCode,
                reasonMessage: $result->reasonMessage,
            );
        }

        return $details;
    }
}
