<?php

declare(strict_types=1);

namespace App\Directory\Actions;

use App\Directory\ApiPlatform\ApiResource\SirenSearchRequestResource;
use App\Directory\Repository\LegalUnitPayloadHistoryRepository;
use App\Directory\ValueObjects\LegalUnitPayloadHistoryOutput;
use App\Directory\ValueObjects\SearchSirenInput;
use App\User\Doctrine\Entity\ApiConsumer;

final readonly class SearchSiren
{
    public function __construct(
        private LegalUnitPayloadHistoryRepository $repository,
    ) {
    }

    public function __invoke(SirenSearchRequestResource $input): SearchSirenInput
    {
        $results = array_map(
            LegalUnitPayloadHistoryOutput::fromEntity(...),
            $this->repository->search(
                $input->filters,
                $input->sorting,
                $input->fields,
                $input->limit
            ),
        );

        return new SearchSirenInput(
            limit: $input->limit,
            filters: $input->filters,
            sorting: $input->sorting,
            fields: $input->fields,
            results: $results
        );
    }
}
