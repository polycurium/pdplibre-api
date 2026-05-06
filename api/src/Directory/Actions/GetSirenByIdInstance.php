<?php

declare(strict_types=1);

namespace App\Directory\Actions;

use App\Directory\Repository\LegalUnitPayloadHistoryRepository;
use App\Directory\ValueObjects\LegalUnitPayloadHistoryOutput;
use App\Common\Exception\ObjectNotFoundException;
final readonly class GetSirenByIdInstance
{
    public function __construct(
        private LegalUnitPayloadHistoryRepository $repository,
    )
    {
    }

    public function __invoke(string $userId, int $idInstance): LegalUnitPayloadHistoryOutput
    {
        $legalUnitPayloadHistory = $this->repository->getSirenByIdInstance($idInstance);

        if (!$legalUnitPayloadHistory) {
            throw new ObjectNotFoundException('SIREN not found');
        }

        return LegalUnitPayloadHistoryOutput::fromEntity($legalUnitPayloadHistory);
    }
}
