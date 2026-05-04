<?php

declare(strict_types=1);

namespace App\Flow\DTO;

use App\Flow\Doctrine\Entity\Flow;
use App\Flow\Enum\FlowProfile;
use App\Flow\Enum\FlowSyntax;
use App\Flow\Enum\ProcessingRule;

/**
 * Identified Flow info: flow info + id + timestamp.
 */
class FullFlowInfo extends FlowInfo
{
    public function __construct(
        /**
         * Unique identifier supporting UUID but not only, for flexibility purpose.
         */
        public string $flowId,

        // Inherited
        \DateTimeInterface $submittedAt,
        string $trackingId,
        string $name,
        ProcessingRule $processingRule,
        FlowSyntax $flowSyntax,
        FlowProfile $flowProfile,
        string $sha256,
    ) {
        parent::__construct(
            $submittedAt,
            $trackingId,
            $name,
            $processingRule,
            $flowSyntax,
            $flowProfile,
            $sha256,
        );
    }

    public static function fromEntity(Flow $flow): self
    {
        return new FullFlowInfo(
            flowId: $flow->getFlowId(),
            submittedAt: $flow->getSubmittedAt(),
            trackingId: $flow->getTrackingId(),
            name: $flow->getName(),
            processingRule: $flow->getProcessingRule(),
            flowSyntax: $flow->getFlowSyntax(),
            flowProfile: $flow->getFlowProfile(),
            sha256: $flow->getSha256(),
        );
    }
}
