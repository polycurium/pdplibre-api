<?php

declare(strict_types=1);

namespace App\Flow\Input;

use App\Common\Exception\InvalidInputException;
use App\Flow\Enum\FlowAckStatus;
use App\Flow\Enum\FlowDirection;
use App\Flow\Enum\FlowType;
use App\Flow\Enum\ProcessingRule;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\IsTrue;

/**
 * Filtering criteria, at least one is required.
 */
final class SearchFlowFilters
{
    public ?string $updatedAfter = null;

    public ?string $updatedBefore = null;

    /** @var array<ProcessingRule>|null */
    #[Assert\All([
        new Assert\NotBlank(),
        new Assert\Choice(callback: [ProcessingRule::class, 'standardCases']),
    ])]
    public ?array $processingRule = null;

    /** @var array<FlowType>|null */
    #[Assert\All([
        new Assert\NotBlank(),
        new Assert\Choice(callback: [FlowType::class, 'standardCases']),
    ])]
    public ?array $flowType = null;

    /** @var array<FlowDirection>|null */
    #[Assert\All([
        new Assert\NotBlank(),
        new Assert\Type(FlowDirection::class),
    ])]
    public ?array $flowDirection = null;

    #[Assert\Length(max: 36)]
    public ?string $trackingId = null;

    public ?FlowAckStatus $ackStatus = null;

    #[IsTrue(message: 'At least one criterion must be provided.')]
    public function hasAtLeastOneCriterion(): bool
    {
        return
            $this->updatedAfter
            || $this->updatedBefore
            || count($this->processingRule ?? []) > 0
            || count($this->flowType ?? []) > 0
            || count($this->flowDirection ?? []) > 0
            || $this->trackingId
            || $this->ackStatus
        ;
    }

    public function updatedAfterAsDateTime(): ?\DateTimeImmutable
    {
        if (!$this->updatedAfter) {
            return null;
        }

        try {
            return new \DateTimeImmutable($this->updatedAfter);
        } catch (\DateMalformedStringException) {
            throw new InvalidInputException('updatedAfter', 'This value is not a valid datetime.');
        }
    }

    public function updatedBeforeAsDateTime(): ?\DateTimeImmutable
    {
        if (!$this->updatedBefore) {
            return null;
        }

        try {
            return new \DateTimeImmutable($this->updatedBefore);
        } catch (\DateMalformedStringException) {
            throw new InvalidInputException('updatedBefore', 'This value is not a valid datetime.');
        }
    }
}
