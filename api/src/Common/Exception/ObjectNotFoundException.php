<?php

namespace App\Common\Exception;

final class ObjectNotFoundException extends \RuntimeException
{
    public function __construct(string $message = 'Object not found')
    {
        parent::__construct($message);
    }
}
