<?php

declare(strict_types=1);

namespace App\Shared\Symfony\MessageBus;

use App\Shared\MessageBus\AsyncMessage;
use App\Shared\MessageBus\MessageBusInterface;
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
