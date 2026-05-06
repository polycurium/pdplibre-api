<?php

declare(strict_types=1);

namespace App\Directory\Doctrine\Entity;

use App\Directory\Enum\EntityType;
use App\Directory\Enum\LegalUnitAdministrativeStatus;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class LegalUnitPayloadHistory
{
    #[ORM\Id]
    private int $idInstance;

    #[ORM\Column(length: 9)]
    private string $siren;

    #[ORM\Column(length: 255)]
    private string $businessName;

    #[ORM\Column]
    private EntityType $entityType;

    #[ORM\Column]
    private LegalUnitAdministrativeStatus $administrativeStatus;

    public function getIdInstance(): int
    {
        return $this->idInstance;
    }

    public function getSiren(): string
    {
        return $this->siren;
    }

    public function getBusinessName(): string
    {
        return $this->businessName;
    }

    public function getEntityType(): EntityType
    {
        return $this->entityType;
    }

    public function getAdministrativeStatus(): LegalUnitAdministrativeStatus
    {
        return $this->administrativeStatus;
    }
}
