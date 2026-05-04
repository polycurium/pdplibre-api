<?php

declare(strict_types=1);

namespace App\Flow\Enum;

enum DocType: string
{
    /**
     * Provides the flow metadata as a JSON payload, no download.
     */
    case Metadata = 'Metadata';

    /**
     * The document that has been initially sent/provided by the emitter.
     */
    case Original = 'Original';

    /**
     * The document that has been optionally converted by the system.
     */
    case Converted = 'Converted';

    /**
     * The document that has been optionally generated as the readable file.
     */
    case ReadableView = 'ReadableView';
}
