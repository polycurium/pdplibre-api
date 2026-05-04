<?php

declare(strict_types=1);

namespace App\Flow\Enum;

enum FlowAckStatus: string
{
    /**
     * The flow is not yet integrated.
     */
    case Pending = 'Pending';

    /**
     * The following checks have passed:
     * - Anti virus
     * - Integrity checks
     * - Technical rules checks
     * - Unicity checks
     */
    case Ok = 'Ok';

    /**
     * One of the previous test has failed.
     */
    case Error = 'Error';
}
