<?php

declare(strict_types=1);

namespace App\Flow\Validation\Format\Validators;

use App\Common\XmlLoader;
use App\Flow\Doctrine\Entity\Flow;
use App\Flow\Enum\FlowSyntax;
use App\Flow\Enum\ReasonCode;
use App\Flow\Validation\FlowValidationContext;
use App\Flow\Validation\FlowValidationResults;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\UniversalBusinessLanguage;

#[AutoconfigureTag('pdplibre.flow.format_validator')]
final readonly class UblFlowFormatValidator extends AbstractFlowFormatValidator
{
    use XmlLoader;

    public function getAllowedSyntax(): FlowSyntax
    {
        return FlowSyntax::UBL;
    }

    public function validate(Flow $flow, FlowValidationContext $context): FlowValidationResults
    {
        if (!$context->fileContent) {
            throw new \RuntimeException('No content.');
        }

        $validationResults = new FlowValidationResults();

        try {
            $dom = self::loadXml($context->fileContent);
            UniversalBusinessLanguage::fromXML($dom);
        } catch (\Throwable $e) {
            $validationResults = $validationResults->withError('invoice.ubl', ReasonCode::InvalidSchema, $e->getMessage());
        }

        return $validationResults;
    }
}
