<?php

declare(strict_types=1);

namespace App\Directory\Input;

use App\Directory\Enum\ContainsOperator;

final class SearchSiretFiltersPostalCode
{
    public ?string $postalCode = null;
    public ContainsOperator $operator = ContainsOperator::opContains;
}
