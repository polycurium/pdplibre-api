<?php

namespace App\Flow\Files\Exception;

class FileNotFoundException extends \RuntimeException
{
    public function __construct(string $message = 'File not found')
    {
        parent::__construct($message);
    }
}
