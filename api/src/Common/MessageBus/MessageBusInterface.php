<?php

declare(strict_types=1);

namespace App\Common\MessageBus;

interface MessageBusInterface
{
    public function dispatch(AsyncMessage $message): void;
}
