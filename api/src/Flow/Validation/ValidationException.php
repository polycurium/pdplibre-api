<?php

namespace App\Flow\Validation;

class ValidationException extends \RuntimeException
{
    public function __construct(
        public readonly string $path,
        public readonly string $exceptionMessage,
        public readonly mixed $invalidValue,
    ) {
        parent::__construct($this->exceptionMessage);
    }

    public function throw(string $path, string $exceptionMessage, mixed $invalidValue): \Exception
    {
        throw new self($path, $exceptionMessage, $invalidValue);
    }
}
