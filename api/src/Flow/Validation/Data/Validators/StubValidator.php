<?php

declare(strict_types=1);

namespace App\Flow\Validation\Data\Validators;

use App\Flow\Doctrine\Entity\Flow;
use App\Flow\Validation\FlowLogicValidator;
use App\Flow\Validation\FlowValidationContext;
use App\Flow\Validation\FlowValidationResults;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('pdplibre.flow.async_validator')]
final readonly class StubValidator implements FlowLogicValidator
{
    public function supports(Flow $flow): bool
    {
        return true;
    }

    public function validate(Flow $flow, FlowValidationContext $context): FlowValidationResults
    {
        // TODO: implement at least one validator
        return new FlowValidationResults();
    }
}
