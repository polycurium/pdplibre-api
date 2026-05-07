<?php

namespace App\Common\Validation;

interface ValidatorInterface
{
    /**
     * @throws ValidationException
     */
    public function validate(object $input): void;
}
