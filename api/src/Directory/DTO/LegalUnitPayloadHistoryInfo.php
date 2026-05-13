<?php

declare(strict_types=1);

namespace App\Directory\DTO;

use App\Directory\Enum\EntityType;
use App\Directory\Enum\LegalUnitAdministrativeStatus;

class LegalUnitPayloadHistoryInfo
{
    public function __construct(
        public ?int $idInstance = null,
        public ?string $siren = null,
        public ?string $businessName = null,
        public ?EntityType $entityType = null,
        public ?LegalUnitAdministrativeStatus $administrativeStatus = null,
    ) {
    }
}
