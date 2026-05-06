<?php

declare(strict_types=1);

namespace App\Directory\Repository;

use App\Directory\Doctrine\Entity\LegalUnitPayloadHistory;

interface LegalUnitPayloadHistoryRepository
{
    /**
     * @param array<string, mixed>             $criteria
     * @param array<string, "desc"|"asc">|null $orderBy
     *
     * @return array<LegalUnitPayloadHistory>
     */
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array;

    /**
     * @param array<string, mixed>             $criteria
     * @param array<string, "desc"|"asc">|null $orderBy
     *
     * @return LegalUnitPayloadHistory|null
     */
    public function findOneBy(array $criteria, ?array $orderBy = null): ?object;

    public function getSirenByIdInstance(int $id): ?LegalUnitPayloadHistory;
    public function getSirenBySirenNumber(string $siren): ?LegalUnitPayloadHistory;
}
