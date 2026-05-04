<?php

declare(strict_types=1);

namespace App\Flow\Validation\Format;

use App\Flow\Enum\FlowSyntax;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final class FlowFormatValidatorRegistry
{
    /** @var array<string, FlowFormatValidator> */
    private array $handlers = [];

    public function __construct(
        #[AutowireIterator('pdplibre.flow.format_handler')]
        iterable $handlers,
    ) {
        foreach ($handlers as $handler) {
            $syntax = $handler->getSupportedSyntax();
            if (isset($this->handlers[$syntax->value])) {
                throw new \LogicException(\sprintf('Duplicate flow format handler found for syntax "%s".', $syntax->value));
            }
            $this->handlers[$syntax->value] = $handler;
        }
    }

    public function getHandler(FlowSyntax $syntax): FlowFormatValidator
    {
        return $this->handlers[$syntax->value]
            ?? throw new \InvalidArgumentException(\sprintf('No flow format handler found for syntax "%s".', $syntax->value));
    }
}
