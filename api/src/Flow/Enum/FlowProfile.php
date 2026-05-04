<?php

declare(strict_types=1);

namespace App\Flow\Enum;

enum FlowProfile: string
{
    // Standard fields
    case Basic = 'Basic';
    case CIUS = 'CIUS';
    case ExtendedCTCFR = 'Extended-CTC-FR';

    // Non-standard fields

    case PendingQualification = 'PendingQualification';

    /** @return array<self> */
    public static function standardCases(): array
    {
        return \array_filter(self::cases(), static fn (self $case) => $case !== self::PendingQualification);
    }
}
