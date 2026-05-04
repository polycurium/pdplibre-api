<?php

declare(strict_types=1);

namespace App\Flow\ApiPlatform\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Flow\Actions\CreateFlow;
use App\Flow\ApiPlatform\ApiResource\CreateFlowResource;
use App\Flow\DTO\FullFlowInfo;
use App\Common\ApiPlatform\ApiValidationException;
use App\Common\Exception\InvalidInputException;
use App\User\Doctrine\Entity\ApiConsumer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final readonly class CreateFlowProcessor implements ProcessorInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private CreateFlow $action,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): FullFlowInfo
    {
        assert($data instanceof CreateFlowResource);
        assert($operation instanceof Post);

        $currentUser = $this->tokenStorage->getToken()?->getUser();
        assert($currentUser instanceof ApiConsumer);

        try {
            $flow = $this->action->__invoke($currentUser, $data);

            return FullFlowInfo::fromEntity($flow);
        } catch (InvalidInputException $e) {
            throw ApiValidationException::create($e->path, $e->getMessage(), $data);
        }
    }
}
