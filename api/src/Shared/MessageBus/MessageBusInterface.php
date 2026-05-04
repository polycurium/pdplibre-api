<?php

declare(strict_types=1);

namespace App\Shared\MessageBus;

use App\Shared\MessageBus\AsyncMessage;

interface MessageBusInterface
{
    public function dispatch(AsyncMessage $message): void;
}
