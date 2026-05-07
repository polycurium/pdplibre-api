<?php

declare(strict_types=1);

namespace App\Directory\Input;

use App\Directory\Enum\LegalUnitAdministrativeStatus;
use App\Directory\Enum\StrictOperator;
use Symfony\Component\Validator\Constraints as Assert;

final class SearchSirenFiltersAdministrativeStatus
{
    #[Assert\All([
        new Assert\NotBlank(),
        new Assert\Choice(callback: [LegalUnitAdministrativeStatus::class, 'standardCases']),
    ])]
    public ?LegalUnitAdministrativeStatus $administrativeStatus = null;
    public StrictOperator $operator = StrictOperator::opStrict;
}
