<?php

declare(strict_types=1);

namespace App\Flow\Enum;

enum ProcessingRule: string
{
    // Standard fields

    /**
     * E-invoicing.
     */
    case B2B = 'B2B';

    /**
     * International B2B e-reporting.
     */
    case B2BInt = 'B2BInt';

    /**
     * B2C e-reporting.
     */
    case B2C = 'B2C';

    /**
     * Out of scope (not regulated flow).
     */
    case OutOfScope = 'OutOfScope';

    /**
     * Archive only, no transmission.
     */
    case ArchiveOnly = 'ArchiveOnly';

    case NotApplicable = 'NotApplicable';

    // Non-standard fields

    case PendingQualification = 'PendingQualification';

    /** @return array<self> */
    public static function standardCases(): array
    {
        return \array_filter(self::cases(), static fn (self $case) => self::PendingQualification !== $case);
    }
}
