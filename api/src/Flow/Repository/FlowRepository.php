<?php

declare(strict_types=1);

namespace App\Flow\Repository;

use App\Flow\Doctrine\Entity\Flow;
use App\Flow\Input\SearchFlowFilters;
use App\User\Doctrine\Entity\ApiConsumer;

interface FlowRepository
{
    public function findById(string $id): ?Flow;

    /**
     * @param array<string, mixed>             $criteria
     * @param array<string, "desc"|"asc">|null $orderBy
     *
     * @return array<Flow>
     */
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array;

    /**
     * @param array<string, mixed>             $criteria
     * @param array<string, "desc"|"asc">|null $orderBy
     *
     * @return Flow|null
     */
    public function findOneBy(array $criteria, ?array $orderBy = null): ?object;

    public function getFlow(string $id, string $ownerId): ?Flow;

    /**
     * @return array<Flow>
     */
    public function search(SearchFlowFilters $filters, int $limit, ApiConsumer $owner): array;
}
