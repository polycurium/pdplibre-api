<?php

declare(strict_types=1);

namespace App\Flow\Validation\Data;

use App\Flow\Actions\ValidateFlow;
use App\Flow\Repository\FlowRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class FlowAsyncValidationHandler
{
    public function __construct(
        private FlowRepository $flowRepository,
        private ValidateFlow $action,
    ) {
    }

    public function __invoke(FlowAsyncValidationMessage $message): void
    {
        $flow = $this->flowRepository->findById($message->flowId);
        if (null === $flow) {
            throw new \RuntimeException(\sprintf('Flow %s not found for async validation.', $message->flowId));
        }

        $this->action->__invoke($flow);
    }
}
