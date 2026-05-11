<?php

declare(strict_types=1);

namespace App\Directory\Doctrine\Entity;

use App\Directory\Enum\DiffusionStatus;
use App\Directory\Enum\FacilityAdministrativeStatus;
use App\Directory\Enum\FacilityType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class AddressRead
{
    #[ORM\Id]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $addressLine1;

    #[ORM\Column(length: 255)]
    private ?string $addressLine2;

    #[ORM\Column(length: 255)]
    private ?string $addressLine3;

    #[ORM\Column(length: 5)]
    private string $postalCode;

    #[ORM\Column(length: 255)]
    private string $countrySubdivision;

    #[ORM\Column(length: 100)]
    private string $locality;

    #[ORM\Column(length: 2)]
    private string $countryCode;

    #[ORM\Column(length: 100)]
    private string $countryName;

    public function getAddressLine1(): string
    {
        return $this->addressLine1;
    }

    public function getAddressLine2(): string
    {
        return $this->addressLine2;
    }

    public function getAddressLine3(): string
    {
        return $this->addressLine3;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCountrySubdivision(): string
    {
        return $this->countrySubdivision;
    }

    public function getLocality(): string
    {
        return $this->locality;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getCountryName(): string
    {
        return $this->countryName;
    }
}
