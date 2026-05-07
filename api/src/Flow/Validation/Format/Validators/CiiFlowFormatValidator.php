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
use Tiime\CrossIndustryInvoice\Basic\CrossIndustryInvoice as BasicCrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\BasicWL\CrossIndustryInvoice as BasicWLCrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\CrossIndustryInvoiceInterface;
use Tiime\CrossIndustryInvoice\EN16931\CrossIndustryInvoice as EN16931CrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\Flux1\CrossIndustryInvoice as Flux1CrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\Minimum\CrossIndustryInvoice as MinimumCrossIndustryInvoice;

#[AutoconfigureTag('pdplibre.flow.format_validator')]
final readonly class CiiFlowFormatValidator extends AbstractFlowFormatValidator
{
    use XmlLoader;

    /**
     * @var array<class-string<CrossIndustryInvoiceInterface>>
     */
    private const array FLAVOURS = [
        'EN16931' => EN16931CrossIndustryInvoice::class,
        'Basic' => BasicCrossIndustryInvoice::class,
        'BasicWL' => BasicWLCrossIndustryInvoice::class,
        'Minimum' => MinimumCrossIndustryInvoice::class,
        'Flux1' => Flux1CrossIndustryInvoice::class,
    ];

    public function getAllowedSyntax(): FlowSyntax
    {
        return FlowSyntax::CII;
    }

    public function validate(Flow $flow, FlowValidationContext $context): FlowValidationResults
    {
        if (!$context->fileContent) {
            throw new \RuntimeException('No content.');
        }

        try {
            $dom = self::loadXml($context->fileContent);
        } catch (\Throwable $e) {
            return new FlowValidationResults()->withError('invoice.cii', ReasonCode::InvalidSchema, $e->getMessage());
        }

        return $this->validateDocument($dom);
    }

    public function validateDocument(\DOMDocument $dom): FlowValidationResults
    {
        $validationResults = new FlowValidationResults();

        $invoice = null;

        // Loop through all possible flavours of CII, from top to bottom.
        foreach (self::FLAVOURS as $formatName => $class) {
            try {
                $invoice = $class::fromXml($dom);
                break;
            } catch (\Throwable $e) {
                $validationResults = $validationResults->withError('invoice.cii.'.$formatName, ReasonCode::InvalidSchema, $e->getMessage());
                $invoice = null;
            }
        }

        if ($invoice) {
            // Invoice exists = skip errors, because it is valid in at least one CII flavour.
            return new FlowValidationResults();
        }

        // No invoice = errors ahead, let's return them.
        return $validationResults;
    }
}
