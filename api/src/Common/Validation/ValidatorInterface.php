<?php

namespace App\Common\Validation;

use RuntimeException;

interface ValidatorInterface
{
    /**
     * @throws RuntimeException in case of any error.
     */
    public function validate(object $input): void;
}
