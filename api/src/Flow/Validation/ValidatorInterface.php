<?php

namespace App\Flow\Validation;

interface ValidatorInterface
{
    /**
     * @throws ValidationException
     */
    public function validate(object $input): void;
}
