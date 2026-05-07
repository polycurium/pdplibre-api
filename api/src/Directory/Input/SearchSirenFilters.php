<?php

declare(strict_types=1);

namespace App\Directory\Input;

use App\Flow\Enum\FlowAckStatus;
use App\Flow\Enum\FlowDirection;
use App\Flow\Enum\FlowType;
use App\Flow\Enum\ProcessingRule;
use App\Common\Exception\InvalidInputException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\IsTrue;

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
