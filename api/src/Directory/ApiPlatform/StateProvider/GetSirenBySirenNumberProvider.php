<?php

declare(strict_types=1);

namespace App\Directory\ApiPlatform\StateProvider;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Common\ApiPlatform\ApiValidationException;
use App\Common\Exception\InvalidInputException;
use App\Common\Exception\ObjectNotFoundException;
use App\Directory\ApiPlatform\ApiResource\GetSirenBySirenNumber;
use App\Directory\Actions\GetSirenBySirenNumber as GetSirenBySirenNumberAction;
use App\User\Doctrine\Entity\ApiConsumer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class GetSirenBySirenNumberProvider implements ProviderInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private  GetSirenBySirenNumberAction $action,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        assert($operation instanceof Get);

        $currentUser = $this->tokenStorage->getToken()?->getUser();
        assert($currentUser instanceof ApiConsumer);
        assert('GetSirenBySirenNumber' === $operation->getName());
        assert(GetSirenBySirenNumber::class === $operation->getClass());

        assert(isset($uriVariables['siren']));

        try {
            $result = $this->action->__invoke($currentUser->getId(), $uriVariables['siren']);
        } catch (ObjectNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        } catch (InvalidInputException $e) {
            throw ApiValidationException::create($e->path, $e->getMessage(), $e);
        }

        return $result;
    }
}
