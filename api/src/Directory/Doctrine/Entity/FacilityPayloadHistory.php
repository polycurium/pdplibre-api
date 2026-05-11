<?php

declare(strict_types=1);

namespace App\Directory\Doctrine\Entity;

use App\Directory\Enum\DiffusionStatus;
use App\Directory\Enum\FacilityAdministrativeStatus;
use App\Directory\Enum\FacilityType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class FacilityPayloadHistory
{
    #[ORM\Id]
    private int $idInstance;

    #[ORM\Column(length: 14)]
    private string $siret;

    #[ORM\Column(length: 9)]
    private string $siren;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column]
    private FacilityType $facilityType;

    #[ORM\Column]
    private DiffusionStatus $diffusible;

    #[ORM\Column]
    private FacilityAdministrativeStatus $administrativeStatus;

    #[ORM\OneToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private AddressRead $address;

    #[ORM\OneToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private B2gAdditionalData $b2gAdditionalData;

    #[ORM\ManyToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private LegalUnitPayloadHistory $legalUnit;

    public function getIdInstance(): int
    {
        return $this->idInstance;
    }

    public function getSiren(): string
    {
        return $this->siren;
    }

    public function getSiret(): string
    {
        return $this->siret;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getFacilityType(): FacilityType
    {
        return $this->facilityType;
    }

    public function getDiffusible(): DiffusionStatus
    {
        return $this->diffusible;
    }

    public function getAdministrativeStatus(): FacilityAdministrativeStatus
    {
        return $this->administrativeStatus;
    }

    public function getAddress(): AddressRead
    {
        return $this->address;
    }

    public function getB2gAdditionalData(): B2gAdditionalData
    {
        return $this->b2gAdditionalData;
    }

    public function getLegalUnit(): LegalUnitPayloadHistory
    {
        return $this->legalUnit;
    }
}
