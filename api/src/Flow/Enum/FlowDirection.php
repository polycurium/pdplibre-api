<?php

declare(strict_types=1);

namespace App\Flow\Enum;

enum FlowDirection: string
{
    /** Incoming flow, from the PDP to the OD */
    case In = 'In';

    /** Outgoing flow, from the OD to the PDP */
    case Out = 'Out';
}
