<?php

declare(strict_types=1);

namespace App\Flow\ApiPlatform\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Flow\Actions\SearchFlow;
use App\Flow\ApiPlatform\ApiResource\FlowSearchRequestResource;
use App\Flow\ValueObjects\SearchFlowInput;
use App\Shared\Exception\ObjectNotFoundException;
use App\Shared\Exception\InvalidInputException;
use App\Shared\ApiPlatform\ApiValidationException;
use App\User\Doctrine\Entity\ApiConsumer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class SearchFlowProcessor implements ProcessorInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private SearchFlow $action,
        private TranslatorInterface $translator,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): SearchFlowInput
    {
        /** @var Request|null $request */
        $request = $context['request'] ?? null;

        $currentUser = $this->tokenStorage->getToken()?->getUser();

        assert($data instanceof FlowSearchRequestResource);
        assert($operation instanceof Post);
        assert($request instanceof Request);
        assert($currentUser instanceof ApiConsumer);
        assert('searchFlow' === $operation->getName());
        assert(FlowSearchRequestResource::class === $operation->getClass());

        try {
            return $this->action->__invoke($currentUser, $data);
        } catch (ObjectNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        } catch (InvalidInputException $e) {
            throw ApiValidationException::create($e->path, $this->translator->trans($e->getMessage(), [], 'validators'), $e);
        }
    }
}
