<?php

declare(strict_types=1);

namespace App\Flow\Validation\Format\Validators;

use App\Flow\Doctrine\Entity\Flow;
use App\Flow\Enum\FlowSyntax;
use App\Flow\Enum\ReasonCode;
use App\Flow\Validation\FlowValidationContext;
use App\Flow\Validation\FlowValidationResults;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('pdplibre.flow.format_handler')]
final readonly class FrrFlowFormatValidator extends AbstractFlowFormatValidator
{
    public function getAllowedSyntax(): FlowSyntax
    {
        return FlowSyntax::FRR;
    }

    public function validate(Flow $flow, FlowValidationContext $context): FlowValidationResults
    {
        // TODO
        return new FlowValidationResults()->withError('invoice.frr', ReasonCode::OtherTechnicalError, 'Not implemented yet');
    }
}
