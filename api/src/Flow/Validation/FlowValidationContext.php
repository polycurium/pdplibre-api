<?php

declare(strict_types=1);

namespace App\Flow\Validation;

final readonly class FlowValidationContext
{
    public function __construct(
        public ?string $fileContent = null,
        public ?string $filePath = null,
    ) {
    }
}
