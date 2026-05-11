<?php

declare(strict_types=1);

namespace App\Directory\Input;

use App\Directory\Enum\ContainsOperator;

final class SearchSiretFiltersSiret
{
    public ?string $siret = null;
    public ContainsOperator $operator = ContainsOperator::opContains;
}
