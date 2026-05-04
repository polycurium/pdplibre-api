<?php

declare(strict_types=1);

namespace App\Flow\ValueObjects;

use App\Flow\Doctrine\Entity\Flow;
use App\Flow\Enum\FlowDirection;
use App\Flow\Enum\FlowProcessingRuleSource;
use App\Flow\Enum\FlowProfile;
use App\Flow\Enum\FlowSyntax;
use App\Flow\Enum\FlowType;
use App\Flow\Enum\ProcessingRule;

final readonly class FlowOutput
{
    public function __construct(
        public string $flowId,
        public \DateTimeInterface $submittedAt,
        public \DateTimeInterface $updatedAt,
        public string $trackingId,
        public FlowType $flowType,
        public ProcessingRule $processingRule,
        public FlowProcessingRuleSource $processingRuleSource,
        public FlowDirection $flowDirection,
        public FlowSyntax $flowSyntax,
        public FlowProfile $flowProfile,
        public AcknowledgementOutput $acknowledgement,
    ) {
    }

    public static function fromEntity(Flow $flow): self
    {
        return new self(
            flowId: $flow->getFlowId(),
            submittedAt: $flow->getSubmittedAt(),
            updatedAt: $flow->getUpdatedAt(),
            trackingId: $flow->getTrackingId(),
            flowType: $flow->getFlowType(),
            processingRule: $flow->getProcessingRule(),
            processingRuleSource: $flow->getProcessingRuleSource(),
            flowDirection: $flow->getFlowDirection(),
            flowSyntax: $flow->getFlowSyntax(),
            flowProfile: $flow->getFlowProfile(),
            acknowledgement: AcknowledgementOutput::fromEntity($flow->getAcknowledgement()),
        );
    }
}
