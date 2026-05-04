<?php

declare(strict_types=1);

namespace App\Flow\ValueObjects;

use App\Flow\Input\SearchFlowFilters;

final readonly class SearchFlowInput
{
    /**
     * @param array<FlowOutput> $results
     */
    public function __construct(
        public int $limit,
        public SearchFlowFilters $filters,
        public array $results,
    ) {
    }
}
