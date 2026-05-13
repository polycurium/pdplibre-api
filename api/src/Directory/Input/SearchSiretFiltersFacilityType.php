<?php

declare(strict_types=1);

namespace App\Directory\Input;

use App\Directory\Enum\ContainsOperator;
use App\Directory\Enum\EntityType;
use App\Directory\Enum\FacilityType;
use Symfony\Component\Validator\Constraints as Assert;

final class SearchSiretFiltersFacilityType
{
    #[Assert\All([
        new Assert\NotBlank(),
        new Assert\Choice(callback: [FacilityType::class, 'standardCases']),
    ])]
    public ?EntityType $entityType = null;
    public ContainsOperator $operator = ContainsOperator::opContains;
}
