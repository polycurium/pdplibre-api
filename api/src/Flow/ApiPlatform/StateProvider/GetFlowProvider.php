<?php

declare(strict_types=1);

namespace App\Flow\ApiPlatform\StateProvider;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Flow\Actions\GetFlow as GetFlowAction;
use App\Flow\ApiPlatform\ApiResource\GetFlow as GetFlowResource;
use App\Flow\ValueObjects\FlowFileStream;
use App\Flow\Files\Exception\FileNotFoundException;
use App\Shared\Exception\ObjectNotFoundException;
use App\Shared\Exception\InvalidInputException;
use App\Shared\ApiPlatform\ApiValidationException;
use App\User\Doctrine\Entity\ApiConsumer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class GetFlowProvider implements ProviderInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private GetFlowAction $action,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        assert($operation instanceof Get);

        $currentUser = $this->tokenStorage->getToken()?->getUser();
        assert($currentUser instanceof ApiConsumer);
        assert('getFlow' === $operation->getName());
        assert(GetFlowResource::class === $operation->getClass());

        assert(isset($uriVariables['flowId']));
        assert(isset($context['request']));

        /** @var Request $request */
        $request = $context['request'];
        assert($request instanceof Request);

        try {
            $result = $this->action->__invoke($currentUser->getId(), $uriVariables['flowId'], $request->query->get('docType'));
        } catch (ObjectNotFoundException|FileNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        } catch (InvalidInputException $e) {
            throw ApiValidationException::create($e->path, $e->getMessage(), $e);
        }

        if ($result instanceof FlowFileStream) {
            return $this->buildStreamedResponse($result);
        }

        return $result;
    }

    private function buildStreamedResponse(FlowFileStream $fileStream): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($fileStream): void {
            $source = $fileStream->stream;
            while (!feof($source)) {
                echo fread($source, 8192);
                flush();
            }
            fclose($source);
        });

        $response->headers->set('Content-Disposition', $response->headers->makeDisposition('attachment', $fileStream->filename));
        $response->headers->set('Content-Length', (string) $fileStream->fileSize);
        $response->headers->set('Content-Type', $fileStream->mimeType);

        return $response;
    }
}
