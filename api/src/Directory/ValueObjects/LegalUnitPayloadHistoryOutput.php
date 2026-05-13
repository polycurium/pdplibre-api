<?php

declare(strict_types=1);

namespace App\Directory\ValueObjects;

use App\Directory\Doctrine\Entity\LegalUnitPayloadHistory;
use App\Directory\Enum\EntityType;
use App\Directory\Enum\LegalUnitAdministrativeStatus;

final class LegalUnitPayloadHistoryOutput
{
    public ?int $idInstance = null;
    public ?string $siren = null;
    public ?string $businessName = null;
    public ?EntityType $entityType = null;
    public ?LegalUnitAdministrativeStatus $administrativeStatus = null;

    public static function fromEntity(LegalUnitPayloadHistory $legalUnitPayloadHistory, ?array $fields = null): self
    {
        $self = new self();

        $returnAll = !$fields;

        if ($returnAll || in_array('idInstance', $fields, true)) {
            $self->idInstance = $legalUnitPayloadHistory->getIdInstance();
        }

        if ($returnAll || in_array('siren', $fields, true)) {
            $self->siren = $legalUnitPayloadHistory->getSiren();
        }

        if ($returnAll || in_array('businessName', $fields, true)) {
            $self->businessName = $legalUnitPayloadHistory->getBusinessName();
        }

        if ($returnAll || in_array('entityType', $fields, true)) {
            $self->entityType = $legalUnitPayloadHistory->getEntityType();
        }

        if ($returnAll || in_array('administrativeStatus', $fields, true)) {
            $self->administrativeStatus = $legalUnitPayloadHistory->getAdministrativeStatus();
        }

        return $self;
    }
}
