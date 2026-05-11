<?php

declare(strict_types=1);

namespace App\Directory\Input;

use App\Directory\Enum\ContainsOperator;

final class SearchSiretFiltersAddressLines
{
    public ?string $addressLines = null;
    public ContainsOperator $operator = ContainsOperator::opContains;
}
