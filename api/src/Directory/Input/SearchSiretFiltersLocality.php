<?php

declare(strict_types=1);

namespace App\Directory\Input;

use App\Directory\Enum\ContainsOperator;

final class SearchSiretFiltersLocality
{
    public ?string $locality = null;
    public ContainsOperator $operator = ContainsOperator::opContains;
}
