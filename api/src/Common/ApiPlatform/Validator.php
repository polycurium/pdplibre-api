<?php

namespace App\Common\ApiPlatform;

use ApiPlatform\Validator\ValidatorInterface as ApiPlatformValidator;
use App\Common\Validation\ValidatorInterface;

final readonly class Validator implements ValidatorInterface
{
    public function __construct(
        private ApiPlatformValidator $validator,
    ) {
    }

    public function validate(object $input): void
    {
        $this->validator->validate($input);
    }
}
