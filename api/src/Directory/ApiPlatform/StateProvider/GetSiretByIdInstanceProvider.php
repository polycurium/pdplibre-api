<?php

declare(strict_types=1);

namespace App\Directory\ApiPlatform\StateProvider;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Common\ApiPlatform\ApiValidationException;
use App\Common\Exception\InvalidInputException;
use App\Common\Exception\ObjectNotFoundException;
use App\Directory\Actions\GetSiretByIdInstance as GetSiretByIdInstanceAction;
use App\Directory\ApiPlatform\ApiResource\GetSiretByIdInstance;
use App\Directory\Validation\GetSiretByIdInstanceValidator;
use App\User\Doctrine\Entity\ApiConsumer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class GetSiretByIdInstanceProvider implements ProviderInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private GetSiretByIdInstanceAction $action,
        private GetSiretByIdInstanceValidator $validator,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        assert($operation instanceof Get);

        $currentUser = $this->tokenStorage->getToken()?->getUser();
        assert($currentUser instanceof ApiConsumer);
        assert('getSiretByIdInstance' === $operation->getName());
        assert(GetSiretByIdInstance::class === $operation->getClass());

        assert(isset($uriVariables['id-instance']));

        /** @var Request|null $request */
        $request = $context['request'] ?? null;

        $fields = $request?->query->all('fields');

        try {
            $this->validator->validate($uriVariables['id-instance'], $fields);
            $result = $this->action->__invoke($uriVariables['id-instance']);
        } catch (ObjectNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        } catch (InvalidInputException $e) {
            throw ApiValidationException::create($e->path, $e->getMessage(), $e);
        }

        return $result;
    }
}
