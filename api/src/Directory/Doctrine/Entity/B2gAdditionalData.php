<?php

declare(strict_types=1);

namespace App\Directory\Doctrine\Entity;

use App\Directory\Enum\DiffusionStatus;
use App\Directory\Enum\EntityType;
use App\Directory\Enum\FacilityAdministrativeStatus;
use App\Directory\Enum\FacilityType;
use App\Directory\Enum\LegalUnitAdministrativeStatus;
use App\Directory\ValueObjects\AddressReadOutput;
use App\Directory\ValueObjects\B2gAdditionalDataOutput;
use App\Flow\Doctrine\Entity\Acknowledgement;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class B2gAdditionalData
{
    #[ORM\Id]
    private int $id;

    #[ORM\Column]
    private bool $pm;

    #[ORM\Column]
    private bool $pmOnly;

    #[ORM\Column]
    private bool $managesPaymentStatus;

    #[ORM\Column]
    private bool $managesLegalCommitmentCode;

    #[ORM\Column]
    private bool $managesLegalCommitmentOrServiceCode;

    #[ORM\Column]
    private bool $serviceCodeStatus;

    public function getPm(): bool
    {
        return $this->pm;
    }

    public function getPmOnly(): bool
    {
        return $this->pmOnly;
    }

    public function getManagesPaymentStatus(): bool
    {
        return $this->managesPaymentStatus;
    }

    public function getManagesLegalCommitmentCode(): bool
    {
        return $this->managesLegalCommitmentCode;
    }

    public function getManagesLegalCommitmentOrServiceCode(): bool
    {
        return $this->managesLegalCommitmentOrServiceCode;
    }

    public function getServiceCodeStatus(): bool
    {
        return $this->serviceCodeStatus;
    }
}
