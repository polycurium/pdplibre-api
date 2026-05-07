<?php

namespace App\Common\ApiPlatform;

use ApiPlatform\Symfony\Validator\Validator as ApiPlatformValidator;
use ApiPlatform\Validator\ValidatorInterface;

final readonly class Validator implements ValidatorInterface
{
    public function __construct(
        private ApiPlatformValidator $validator,
    ) {
    }

    public function validate(object $data, array $context = []): void
    {
        $this->validator->validate($data, $context);
    }
}
