<?php

namespace App\Shared\ApiPlatform;

use ApiPlatform\Validator\Exception\ValidationException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Simpler method to use API Platform's exception
 */
class ApiValidationException
{
    public static function create(string $path, string $message, mixed $invalidValue): ValidationException
    {
        return new ValidationException(new ConstraintViolationList([new ConstraintViolation($message, $message, [], null, $path, $invalidValue)]));
    }
}
