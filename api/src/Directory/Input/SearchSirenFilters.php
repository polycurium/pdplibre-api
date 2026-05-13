<?php

declare(strict_types=1);

namespace App\Directory\Input;

/**
 * Filtering criteria, at least one is required.
 */
final class SearchSirenFilters
{
    public ?SearchSirenFiltersSiren $siren = null;
    public ?SearchSirenFiltersBusinessName $businessName = null;
    public ?SearchSirenFiltersEntityType $entityType = null;
    public ?SearchSirenFiltersAdministrativeStatus $administrativeStatus = null;
}
