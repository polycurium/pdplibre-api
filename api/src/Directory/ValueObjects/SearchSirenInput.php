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
        public ?int $limit = null,
         // TODO public ?int $ignore = null,
        public SearchSirenFilters $filters,
        public ?array $sorting = null,
        public ?array $fields = null,
        public ?array $results = null
    ) {
    }
}
