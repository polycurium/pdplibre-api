<?php

declare(strict_types=1);

namespace App\Directory\Input;

/**
 * Filtering criteria, at least one is required.
 */
final class SearchSiretFilters
{
    public ?SearchSiretFiltersSiret $siret = null;
    public ?SearchSirenFiltersSiren $siren = null;
    public ?SearchSiretFiltersFacilityType $facilityType = null;
    public ?SearchSiretFiltersName $name = null;
    public ?SearchSiretFiltersAddressLines $addressLines = null;
    public ?SearchSiretFiltersPostalCode $postalCode = null;
    public ?SearchSiretFiltersCountrySubdivision $countrySubdivision = null;
    public ?SearchSiretFiltersLocality $locality = null;
    public ?SearchSiretFiltersAdministrativeStatus $administrativeStatus = null;
}
