<?php

declare(strict_types=1);

namespace App\Flow\Input;

use App\Flow\Doctrine\Entity\Flow;
use App\Flow\Enum\FlowProfile;
use App\Flow\Enum\FlowSyntax;
use App\Flow\Enum\ProcessingRule;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @see \App\Flow\DTO\FlowInfo
 */
class FlowInfoInput
{
    #[Assert\GreaterThanOrEqual('now')]
    public ?\DateTimeInterface $submittedAt = null;

    #[Assert\Length(max: 36)]
    public ?string $trackingId = null;

    /** Name of the file. */
    #[Assert\Length(max: 255)]
    public ?string $name = null;

    #[Assert\Choice(callback: [ProcessingRule::class, 'standardCases'])]
    public ?ProcessingRule $processingRule = null;

    #[Assert\Choice(callback: [FlowSyntax::class, 'cases'])]
    #[Assert\NotNull]
    public ?FlowSyntax $flowSyntax = null;

    #[Assert\Choice(callback: [FlowProfile::class, 'standardCases'])]
    public ?FlowProfile $flowProfile = null;

    #[Assert\Regex(pattern: Flow::FILE_HASH_REGEX)]
    public ?string $sha256 = null;
}
