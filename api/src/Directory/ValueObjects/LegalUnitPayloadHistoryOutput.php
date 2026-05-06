<?php

declare(strict_types=1);

namespace App\Directory\ValueObjects;

use App\Directory\Doctrine\Entity\LegalUnitPayloadHistory;
use App\Directory\Enum\EntityType;
use App\Directory\Enum\LegalUnitAdministrativeStatus;

final readonly class LegalUnitPayloadHistoryOutput
{
    public function __construct(
        public int $idInstance,
        public string $siren,
        public string $businessName,
        public EntityType $entityType,
        public LegalUnitAdministrativeStatus $administrativeStatus,
    ) {
    }

    public static function fromEntity(LegalUnitPayloadHistory $legalUnitPayloadHistory): self
    {
        return new self(
            idInstance: $legalUnitPayloadHistory->getIdInstance(),
            siren: $legalUnitPayloadHistory->getSiren(),
            businessName: $legalUnitPayloadHistory->getBusinessName(),
            entityType: $legalUnitPayloadHistory->getEntityType(),
            administrativeStatus: $legalUnitPayloadHistory->getAdministrativeStatus(),
        );
    }
}
