<?php

declare(strict_types=1);

namespace App\Flow\ValueObjects;

final readonly class FlowFileStream
{
    /**
     * @param resource $stream
     */
    public function __construct(
        public string $filename,
        public string $mimeType,
        public int $fileSize,
        public mixed $stream,
    ) {
    }
}
