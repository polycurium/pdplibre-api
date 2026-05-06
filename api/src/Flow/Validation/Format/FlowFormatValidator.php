<?php

declare(strict_types=1);

namespace App\Flow\Validation\Format;

use App\Flow\Enum\FlowSyntax;
use App\Flow\Validation\FlowLogicValidator;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('pdplibre.flow.format_validator')]
interface FlowFormatValidator extends FlowLogicValidator
{
    public function getAllowedSyntax(): FlowSyntax;
}
