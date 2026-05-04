<?php

namespace App\Flow\Validation\Format\Validators;

use App\Flow\Doctrine\Entity\Flow;
use App\Flow\Validation\Format\FlowFormatValidator;

abstract readonly class AbstractFlowFormatValidator implements FlowFormatValidator
{
    public function supports(Flow $flow): bool
    {
        return $this->getAllowedSyntax() === $flow->getFlowSyntax();
    }
}
