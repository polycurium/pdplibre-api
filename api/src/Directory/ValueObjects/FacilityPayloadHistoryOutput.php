<?php

declare(strict_types=1);

namespace App\Directory\ValueObjects;

use App\Directory\Doctrine\Entity\FacilityPayloadHistory;
use App\Directory\Enum\DiffusionStatus;
use App\Directory\Enum\FacilityAdministrativeStatus;
use App\Directory\Enum\FacilityType;

final readonly class FacilityPayloadHistoryOutput
{
    public function __construct(
        public int $idInstance,
        public string $siret,
        public string $siren,
        public string $name,
        public FacilityType $facilityType,
        public DiffusionStatus $diffusible,
        public FacilityAdministrativeStatus $administrativeStatus,
        public AddressReadOutput $address,
        public B2gAdditionalDataOutput $b2gAdditionalData,
        public LegalUnitPayloadIncludedNoSirenOutput $legalUnit
    ) {
    }

    public static function fromEntity(FacilityPayloadHistory $facilityPayloadHistory): self
    {
        return new self(
            idInstance: $facilityPayloadHistory->getIdInstance(),
            siret: $facilityPayloadHistory->getSiret(),
            siren: $facilityPayloadHistory->getSiren(),
            name: $facilityPayloadHistory->getName(),
            facilityType: $facilityPayloadHistory->getFacilityType(),
            diffusible: $facilityPayloadHistory->getDiffusible(),
            administrativeStatus: $facilityPayloadHistory->getAdministrativeStatus(),
            address: AddressReadOutput::fromEntity($facilityPayloadHistory->getAddress()),
            b2gAdditionalData: B2gAdditionalDataOutput::fromEntity($facilityPayloadHistory->getB2gAdditionalData()),
            legalUnit: LegalUnitPayloadIncludedNoSirenOutput::fromEntity($facilityPayloadHistory->getLegalUnit()),
        );
    }
}
