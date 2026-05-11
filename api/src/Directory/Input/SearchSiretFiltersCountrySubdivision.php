<?php

declare(strict_types=1);

namespace App\Directory\Input;

use App\Directory\Enum\ContainsOperator;

final class SearchSiretFiltersCountrySubdivision
{
    public ?string $countrySubdivision = null;
    public ContainsOperator $operator = ContainsOperator::opContains;
}
