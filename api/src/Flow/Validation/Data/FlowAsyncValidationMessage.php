<?php

declare(strict_types=1);

namespace App\Flow\Validation\Data;

use App\Shared\MessageBus\AsyncMessage;

final readonly class FlowAsyncValidationMessage implements AsyncMessage
{
    public function __construct(
        public string $flowId,
    ) {
    }
}
