<?php

declare(strict_types=1);

namespace App\Common\Symfony\MessageBus;

use App\Common\MessageBus\AsyncMessage;
use App\Common\MessageBus\MessageBusInterface;
use Symfony\Component\Messenger\MessageBusInterface as SymfonyMessageBusInterface;

final readonly class SymfonyMessengerBus implements MessageBusInterface
{
    public function __construct(
        private SymfonyMessageBusInterface $messageBus,
    ) {
    }

    public function dispatch(AsyncMessage $message): void
    {
        $this->messageBus->dispatch($message);
    }
}
