<?php

declare(strict_types=1);

namespace App\Flow\DTO;

use App\Flow\Enum\FlowProfile;
use App\Flow\Enum\FlowSyntax;
use App\Flow\Enum\ProcessingRule;

/**
 *  Signaling of the flow:
 * - if tracking ID or sha256 are provided in the request: it should be checked once received
 * - if tracking ID or sha256 are not provided in the request: it should be computed and returned in the response
 */
class FlowInfo
{
    public function __construct(
        /**
         * The flow submission date and time (the date and time when the flow was created on the system)
         * This property should be used by the API consumer as a time reference to avoid clock synchronization issues.
         */
        public \DateTimeInterface $submittedAt,

        /**
         * An external identifier used to track the flow by the sender.
         */
        public string $trackingId,

        /**
         * Name of the file.
         */
        public string $name,

        /**
         * - B2B                 : e-invoicing
         * - B2BInt              : International B2B e-reporting
         * - B2C                 : B2C e-reporting
         * - OutOfScope          : Out of scope (not regulated flow)
         * - ArchiveOnly         : Archive only, no transmission
         * - NotApplicable       : Not Applicable.
         */
        public ProcessingRule $processingRule,

        /**
         * Syntax of the original file belonging to a flow.
         */
        public FlowSyntax $flowSyntax,

        public FlowProfile $flowProfile,

        /**
         * Fingerprint of the attached file.
         */
        public string $sha256,
    ) {
    }
}
