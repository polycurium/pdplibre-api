<?php

declare(strict_types=1);

namespace App\Directory\ApiPlatform\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Common\ApiPlatform\ApiValidationException;
use App\Common\Exception\InvalidInputException;
use App\Common\Exception\ObjectNotFoundException;
use App\Directory\Actions\SearchSiret;
use App\Directory\ApiPlatform\ApiResource\SiretSearchRequestResource;
use App\Directory\ValueObjects\SearchSiretInput;
use App\User\Doctrine\Entity\ApiConsumer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class SearchSiretProcessor implements ProcessorInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private SearchSiret $action,
        private TranslatorInterface $translator,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): SearchSiretInput
    {
        /** @var Request|null $request */
        $request = $context['request'] ?? null;

        $currentUser = $this->tokenStorage->getToken()?->getUser();

        assert($data instanceof SiretSearchRequestResource);
        assert($operation instanceof Post);
        assert($request instanceof Request);
        assert($currentUser instanceof ApiConsumer);
        assert('searchSiret' === $operation->getName());
        assert(SiretSearchRequestResource::class === $operation->getClass());

        try {
            return $this->action->__invoke($data);
        } catch (ObjectNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        } catch (InvalidInputException $e) {
            throw ApiValidationException::create($e->path, $this->translator->trans($e->getMessage(), [], 'validators'), $e);
        }
    }
}
