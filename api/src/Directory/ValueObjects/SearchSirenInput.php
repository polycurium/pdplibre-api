<?php

declare(strict_types=1);

namespace App\Directory\ValueObjects;

use App\Directory\Input\SearchSirenFilters;
use App\Directory\Input\SearchSirenSorting;

final readonly class SearchSirenInput
{
    /**
     * @param array<LegalUnitPayloadHistoryOutput> $results
     */
    /**
     * @param array<SearchSirenSorting> $sorting
     */
    public function __construct(
        public int $limit,
         // TODO public int $ignore,
        public SearchSirenFilters $filters,
        public array $sorting,
        public array $fields,
        public array $results
    ) {
    }
}
