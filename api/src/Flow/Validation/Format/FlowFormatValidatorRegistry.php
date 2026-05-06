<?php

declare(strict_types=1);

namespace App\Flow\Validation\Format;

use App\Flow\Enum\FlowSyntax;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final class FlowFormatValidatorRegistry
{
    /** @var array<string, FlowFormatValidator> */
    private array $flowFormatValidators = [];

    /** @param FlowFormatValidator[] $flowFormatValidators */
    public function __construct(
        #[AutowireIterator('pdplibre.flow.format_validator')]
        iterable $flowFormatValidators,
    ) {
        foreach ($flowFormatValidators as $flowFormatValidator) {
            $syntax = $flowFormatValidator->getAllowedSyntax();
            if (isset($this->flowFormatValidators[$syntax->value])) {
                throw new \LogicException(\sprintf('Duplicate flow format validator found for syntax "%s".', $syntax->value));
            }
            $this->flowFormatValidators[$syntax->value] = $flowFormatValidator;
        }
    }

    public function getFormatValidator(FlowSyntax $syntax): FlowFormatValidator
    {
        return $this->flowFormatValidators[$syntax->value]
            ?? throw new \InvalidArgumentException(\sprintf('No flow format validator found for syntax "%s".', $syntax->value));
    }
}
