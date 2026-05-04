<?php

declare(strict_types=1);

namespace App\Flow\Actions;

use App\Flow\ApiPlatform\ApiResource\FlowSearchRequestResource;
use App\Flow\Repository\FlowRepository;
use App\Flow\ValueObjects\FlowOutput;
use App\Flow\ValueObjects\SearchFlowInput;
use App\User\Doctrine\Entity\ApiConsumer;

final readonly class SearchFlow
{
    public function __construct(
        private FlowRepository $flowRepository,
    ) {
    }

    public function __invoke(ApiConsumer $currentUser, FlowSearchRequestResource $input): SearchFlowInput
    {
        $this->validateInput($input);

        $results = array_map(
            FlowOutput::fromEntity(...),
            $this->flowRepository->search(
                $input->where,
                $input->limit,
                $currentUser,
            ),
        );

        return new SearchFlowInput(
            limit: $input->limit,
            filters: $input->where,
            results: $results,
        );
    }

    private function validateInput(FlowSearchRequestResource $input): void
    {
        // These methods already trigger validation.
        $input->where->updatedAfterAsDateTime();
        $input->where->updatedBeforeAsDateTime();
    }
}
