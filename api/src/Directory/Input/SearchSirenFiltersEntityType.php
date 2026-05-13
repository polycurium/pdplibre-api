<?php

declare(strict_types=1);

namespace App\Directory\Input;

use App\Directory\Enum\EntityType;
use App\Directory\Enum\StrictOperator;
use Symfony\Component\Validator\Constraints as Assert;

final class SearchSirenFiltersEntityType
{
    #[Assert\All([
        new Assert\NotBlank(),
        new Assert\Choice(callback: [EntityType::class, 'standardCases']),
    ])]
    public ?EntityType $entityType = null;
    public StrictOperator $operator = StrictOperator::opStrict;
}
