<?php

namespace App\Common\Exception;

final class InvalidInputException extends \RuntimeException
{
    public function __construct(
        public readonly string $path,
        string $message,
    ) {
        parent::__construct($message);
    }
}
