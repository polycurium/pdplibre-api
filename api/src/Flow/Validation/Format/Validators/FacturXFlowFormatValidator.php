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
use Tiime\FacturX\Reader;

#[AutoconfigureTag('pdplibre.flow.format_validator')]
final readonly class FacturXFlowFormatValidator extends AbstractFlowFormatValidator
{
    use XmlLoader;

    public function __construct(private CiiFlowFormatValidator $ciiFlowFormatValidator)
    {
    }

    public function getAllowedSyntax(): FlowSyntax
    {
        return FlowSyntax::FACTUR_X;
    }

    public function validate(Flow $flow, FlowValidationContext $context): FlowValidationResults
    {
        if (!$context->fileContent) {
            throw new \RuntimeException('No content.');
        }

        $validationResults = new FlowValidationResults();

        try {
            $reader = new Reader();
            $xml = $reader->extractXML($context->fileContent);
            $dom = self::loadXml($xml);
            $validationResults = $validationResults->mergeWith($this->ciiFlowFormatValidator->validateDocument($dom));
        } catch (\Throwable $e) {
            $validationResults = $validationResults->withError('invoice.facturx', ReasonCode::InvalidSchema, $e->getMessage());
        }

        return $validationResults;
    }
}
