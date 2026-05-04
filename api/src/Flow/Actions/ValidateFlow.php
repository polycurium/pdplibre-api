<?php

declare(strict_types=1);

namespace App\Flow\Actions;

use App\Flow\Doctrine\Entity\AcknowledgementDetail;
use App\Flow\Doctrine\Entity\Flow;
use App\Flow\Enum\AcknowledgementDetailLevel;
use App\Flow\Enum\ReasonCode;
use App\Flow\Repository\FlowRepository;
use App\Flow\Validation\FlowLogicValidator;
use App\Flow\Validation\FlowValidationContext;
use App\Flow\Validation\FlowValidationResultItem;
use App\Flow\Validation\FlowValidationResults;
use Doctrine\Persistence\ManagerRegistry;
use League\Flysystem\FilesystemOperator;
use Psr\Clock\ClockInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final readonly class ValidateFlow
{
    /**
     * @param iterable<FlowLogicValidator> $validators
     */
    public function __construct(
        private FlowRepository $flowRepository,
        private ManagerRegistry $managerRegistry,
        private ClockInterface $clock,
        #[AutowireIterator('pdplibre.flow.async_validator')]
        private iterable $validators,
        private FilesystemOperator $uploadedFilesStorage,
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(Flow $flow): void
    {
        try {
            $fileContent = $this->uploadedFilesStorage->read($flow->getName());
        } catch (\Throwable $e) {
            $this->logger->error('Failed to read flow file for async validation.', [
                'flowId' => $flow->getId(),
                'error' => $e->getMessage(),
            ]);

            $this->markAsError($flow, new FlowValidationResults([
                new FlowValidationResultItem(
                    AcknowledgementDetailLevel::Error,
                    'file',
                    ReasonCode::OtherTechnicalError,
                    'Failed to read flow file: '.$e->getMessage(),
                ),
            ]));

            return;
        }

        $context = new FlowValidationContext(fileContent: $fileContent);
        $validationResults = new FlowValidationResults();

        foreach ($this->validators as $validator) {
            if (!$validator->supports($flow)) {
                continue;
            }

            try {
                $results = $validator->validate($flow, $context);
                $validationResults = $validationResults->mergeWith($results);
            } catch (\Throwable $e) {
                $this->logger->error('Async validation handler failed unexpectedly.', [
                    'flowId' => $flow->getId(),
                    'handler' => $validator::class,
                    'error' => $e->getMessage(),
                ]);
                $validationResults = $validationResults->mergeWith(new FlowValidationResults([
                    new FlowValidationResultItem(
                        AcknowledgementDetailLevel::Error,
                        'file',
                        ReasonCode::OtherTechnicalError,
                        \sprintf('Unexpected error in %s: %s', $validator::class, $e->getMessage()),
                    ),
                ]));
            }
        }

        if ($validationResults->hasErrors()) {
            $this->markAsError($flow, $validationResults);
        } else {
            $this->markAsOk($flow);
        }
    }

    private function markAsOk(Flow $flow): void
    {
        $em = $this->managerRegistry->getManagerForClass(Flow::class);
        if (!$em) {
            throw new \RuntimeException('No entity manager for class '.Flow::class);
        }
        $flow->markAcknowledgementOk(\DateTimeImmutable::createFromInterface($this->clock->now()));
        $em->flush();
    }

    private function markAsError(Flow $flow, FlowValidationResults $resultCollection): void
    {
        $em = $this->managerRegistry->getManagerForClass(Flow::class);
        if (!$em) {
            throw new \RuntimeException('No entity manager for class '.Flow::class);
        }

        $details = [];
        foreach ($resultCollection->results as $result) {
            $details[] = new AcknowledgementDetail(
                acknowledgement: $flow->getAcknowledgement(),
                level: $result->level,
                item: $result->item,
                reasonCode: $result->reasonCode,
                reasonMessage: $result->reasonMessage,
            );
        }

        $flow->markAcknowledgementError($details, \DateTimeImmutable::createFromInterface($this->clock->now()));

        $em->flush();
    }
}
