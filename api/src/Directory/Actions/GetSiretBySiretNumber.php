<?php

declare(strict_types=1);

namespace App\Directory\Actions;

use App\Directory\Repository\FacilityPayloadHistoryRepository;
use App\Directory\ValueObjects\FacilityPayloadHistoryOutput;
use App\Common\Exception\ObjectNotFoundException;
final readonly class GetSiretBySiretNumber
{
    public function __construct(
        private FacilityPayloadHistoryRepository $repository,
    )
    {
    }

    public function __invoke(string $siret): FacilityPayloadHistoryOutput
    {
        $facilityPayloadHistory = $this->repository->getSiretBySiretNumber($siret);

        if (!$facilityPayloadHistory) {
            throw new ObjectNotFoundException('SIREN not found');
        }

        return FacilityPayloadHistoryOutput::fromEntity($facilityPayloadHistory);
    }
}
