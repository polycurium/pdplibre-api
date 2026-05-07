<?php

declare(strict_types=1);

namespace App\Flow\Actions;

use App\Common\MessageBus\MessageBusInterface;
use App\Common\Validation\ValidatorInterface;
use App\Flow\ApiPlatform\ApiResource\CreateFlowResource;
use App\Flow\Doctrine\Entity\Flow;
use App\Flow\Validation\Data\FlowAsyncValidationMessage;
use App\Flow\Validation\FlowValidationContext;
use App\Flow\Validation\Format\FlowFormatValidatorRegistry;
use App\Flow\ValueObjects\ValidFlowInput;
use App\User\Doctrine\Entity\ApiConsumer;
use Doctrine\Persistence\ManagerRegistry;
use League\Flysystem\FilesystemOperator;
use Psr\Clock\ClockInterface;
use Symfony\Component\Uid\Uuid;

final readonly class CreateFlow
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private ValidatorInterface $validator,
        private ClockInterface $clock,
        private FilesystemOperator $uploadedFilesStorage,
        private FlowFormatValidatorRegistry $formatValidatorRegistry,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function __invoke(ApiConsumer $currentUser, CreateFlowResource $input): Flow
    {
        $this->validator->validate($input);

        $validInput = new ValidFlowInput($this->fillOptionalDependentFields($input));

        $flow = Flow::fromCreateApi($currentUser, $validInput);

        $em = $this->managerRegistry->getManagerForClass(Flow::class);
        if (!$em) {
            throw new \RuntimeException('No entity manager for class '.Flow::class);
        }

        $formatValidator = $this->formatValidatorRegistry->getHandler($validInput->flowSyntax);
        $formatResults = $formatValidator->validate($flow, new FlowValidationContext(fileContent: $input->file->getContent()));

        if ($formatResults->hasErrors()) {
            // Errors case
            $details = $formatResults->asAcknowledgementDetails($flow->getAcknowledgement());

            $flow->markAcknowledgementError($details, \DateTimeImmutable::createFromInterface($this->clock->now()));
        } else {
            // Success case
            $this->uploadedFilesStorage->write(
                $flow->getId().'-'.$input->file->getClientOriginalName(),
                $input->file->getContent(),
            );
        }

        $em->persist($flow);
        $em->flush();

        $this->messageBus->dispatch(new FlowAsyncValidationMessage($flow->getFlowId()));

        return $flow;
    }

    private function fillOptionalDependentFields(CreateFlowResource $input): CreateFlowResource
    {
        if (!$input->flowInfo->trackingId) {
            $input->flowInfo->trackingId = \str_replace('-', '', Uuid::v7()->toString());
        }

        if (!$input->flowInfo->submittedAt) {
            $input->flowInfo->submittedAt = \DateTimeImmutable::createFromInterface($this->clock->now());
        }

        return $input;
    }
}
