<?php

declare(strict_types=1);

namespace App\Flow\Validation;

use App\Flow\Doctrine\Entity\Flow;

interface FlowLogicValidator
{
    public function validate(Flow $flow, FlowValidationContext $context): FlowValidationResults;

    public function supports(Flow $flow): bool;
}
