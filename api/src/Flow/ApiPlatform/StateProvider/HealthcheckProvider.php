<?php

declare(strict_types=1);

namespace App\Flow\ApiPlatform\StateProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Flow\ApiPlatform\ApiResource\Healthcheck;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception as DBALException;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class HealthcheckProvider implements ProviderInterface
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        try {
            $this->connection->executeQuery('SELECT 1');

            return new Healthcheck();
        } catch (\Throwable $e) {
            $isDatabaseError = $e instanceof DBALException;

            return new JsonResponse(
                [
                    'errorCode' => $isDatabaseError ? 'RESOURCE_ERROR' : 'INTERNAL_ERROR',
                    'errorMessage' => $isDatabaseError
                        ? 'Database connection is unavailable.'
                        : 'An unexpected error occurred.',
                ],
                $isDatabaseError ? 503 : 500,
            );
        }
    }
}
