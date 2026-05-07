<?php

declare(strict_types=1);

namespace App\Directory\ApiPlatform\StateProvider;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Common\ApiPlatform\ApiValidationException;
use App\Common\Exception\InvalidInputException;
use App\Common\Exception\ObjectNotFoundException;
use App\Directory\ApiPlatform\ApiResource\GetSirenByIdInstance;
use App\Directory\Actions\GetSirenByIdInstance as GetSirenByIdInstanceAction;
use App\User\Doctrine\Entity\ApiConsumer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class GetSirenByIdInstanceProvider implements ProviderInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private  GetSirenByIdInstanceAction $action,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        assert($operation instanceof Get);

        $currentUser = $this->tokenStorage->getToken()?->getUser();
        assert($currentUser instanceof ApiConsumer);
        assert('getSirenByIdInstance' === $operation->getName());
        assert(GetSirenByIdInstance::class === $operation->getClass());

        assert(isset($uriVariables['id-instance']));

        try {
            $result = $this->action->__invoke($uriVariables['id-instance']);
        } catch (ObjectNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        } catch (InvalidInputException $e) {
            throw ApiValidationException::create($e->path, $e->getMessage(), $e);
        }

        return $result;
    }
}
