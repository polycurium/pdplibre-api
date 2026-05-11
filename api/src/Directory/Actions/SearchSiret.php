<?php

declare(strict_types=1);

namespace App\Directory\Actions;

use App\Directory\ApiPlatform\ApiResource\SiretSearchRequestResource;
use App\Directory\Repository\FacilityPayloadHistoryRepository;
use App\Directory\ValueObjects\FacilityPayloadHistoryOutput;
use App\Directory\ValueObjects\SearchSiretInput;

final readonly class SearchSiret
{
    public function __construct(
        private FacilityPayloadHistoryRepository $repository,
    ) {
    }

    public function __invoke(SiretSearchRequestResource $input): SearchSiretInput
    {
        $results = array_map(
            FacilityPayloadHistoryOutput::fromEntity(...),
            $this->repository->search(
                $input->filters,
                $input->sorting,
                $input->fields,
                $input->limit
            ),
        );

        return new SearchSiretInput(
            limit: $input->limit,
            filters: $input->filters,
            sorting: $input->sorting,
            fields: $input->fields,
            results: $results
        );
    }
}
