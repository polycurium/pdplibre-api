<?php

declare(strict_types=1);

namespace App\Directory\Input;

use App\Directory\Enum\FacilityAdministrativeStatus;
use App\Directory\Enum\StrictOperator;
use Symfony\Component\Validator\Constraints as Assert;

final class SearchSiretFiltersAdministrativeStatus
{
    #[Assert\All([
        new Assert\NotBlank(),
        new Assert\Choice(callback: [FacilityAdministrativeStatus::class, 'standardCases']),
    ])]
    public ?FacilityAdministrativeStatus $administrativeStatus = null;
    public StrictOperator $operator = StrictOperator::opStrict;
}
