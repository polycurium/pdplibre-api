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
final readonly class CdarFlowFormatValidator extends AbstractFlowFormatValidator
{
    public function getAllowedSyntax(): FlowSyntax
    {
        return FlowSyntax::CDAR;
    }

    public function validate(Flow $flow, FlowValidationContext $context): FlowValidationResults
    {
        // TODO
        return new FlowValidationResults()->withError('invoice.cdar', ReasonCode::OtherTechnicalError, 'Not implemented yet');
    }
}
