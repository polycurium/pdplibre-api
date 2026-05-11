<?php

declare(strict_types=1);

namespace App\Directory\Repository;

use App\Directory\Doctrine\Entity\FacilityPayloadHistory;
use App\Directory\Input\SearchSirenFilters;
use App\Directory\Input\SearchSirenSorting;

interface FacilityPayloadHistoryRepository
{
    /**
     * @param array<string, mixed>             $criteria
     * @param array<string, "desc"|"asc">|null $orderBy
     *
     * @return array<FacilityPayloadHistory>
     */
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array;

    /**
     * @param array<string, mixed>             $criteria
     * @param array<string, "desc"|"asc">|null $orderBy
     *
     * @return FacilityPayloadHistory|null
     */
    public function findOneBy(array $criteria, ?array $orderBy = null): ?object;

    public function getSiretByIdInstance(int $id): ?FacilityPayloadHistory;
    public function getSiretBySiretNumber(string $siret): ?FacilityPayloadHistory;

//    //TODO rajouter ignore
//    /**
//     * @return array<FacilityPayloadHistory>
//     */
//    /**
//     * @param array<SearchSirenSorting> $sorting
//     */
//    /**
//     * @param array<string> $fields
//     */
//    public function search(SearchSirenFilters $filters, ?array $sorting, ?array $fields, ?int $limit): array;
}
