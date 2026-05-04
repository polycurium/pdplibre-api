<?php

declare(strict_types=1);

namespace App\Flow\ValueObjects;

use App\Flow\ApiPlatform\ApiResource\CreateFlowResource;
use App\Flow\Doctrine\Entity\Flow;
use App\Flow\Enum\FlowProcessingRuleSource;
use App\Flow\Enum\FlowProfile;
use App\Flow\Enum\FlowSyntax;
use App\Flow\Enum\ProcessingRule;
use App\Shared\Exception\InvalidInputException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class ValidFlowInput
{
    public \DateTimeInterface $submittedAt;
    public string $trackingId;
    public string $name;
    public ProcessingRule $processingRule;
    public FlowSyntax $flowSyntax;
    public FlowProfile $flowProfile;
    public string $sha256;
    public FlowProcessingRuleSource $processingRuleSource;
    public UploadedFile $file;

    public function __construct(CreateFlowResource $input)
    {
        $this->sha256 = \hash_file('sha256', $input->file->getRealPath());

        $this->validateInput($input);

        $this->submittedAt = $input->flowInfo->submittedAt;
        $this->trackingId = $input->flowInfo->trackingId;
        $this->flowSyntax = $input->flowInfo->flowSyntax;
        $this->file = $input->file;

        $this->name = $input->file->getClientOriginalName();

        // TODO: find better way to do this according to the specs
        if (!$input->flowInfo->flowProfile) {
            $this->flowProfile = FlowProfile::PendingQualification;
        } else {
            $this->flowProfile = $input->flowInfo->flowProfile;
        }

        if ($input->flowInfo->processingRule) {
            $this->processingRule = $input->flowInfo->processingRule;
            $this->processingRuleSource = FlowProcessingRuleSource::Input;
        } else {
            $this->processingRule = ProcessingRule::PendingQualification;
            $this->processingRuleSource = FlowProcessingRuleSource::Computed;
        }
    }

    private function validateInput(CreateFlowResource $input): void
    {
        if (!$input->flowInfo) {
            throw new InvalidInputException('flowInfo', 'Flow info are required.');
        }
        if (!$input->file) {
            throw new InvalidInputException('file', 'Flow file is required.');
        }

        if (!$input->flowInfo->flowSyntax) {
            throw new InvalidInputException('flowInfo.flowSyntax', 'Flow syntax is required.');
        }
        if (!$input->flowInfo->trackingId) {
            throw new InvalidInputException('flowInfo.trackingId', 'Flow tracking ID is required.');
        }

        if ($input->flowInfo->sha256 && !\preg_match(Flow::FILE_HASH_REGEX, $input->flowInfo->sha256)) {
            throw new InvalidInputException('flowInfo.sha256', \sprintf('File\'s SHA256 hash is not valid, and must respect this regex: "%s".', Flow::FILE_HASH_REGEX));
        }
        if ($input->flowInfo->sha256 && $this->sha256 !== $input->flowInfo->sha256) {
            throw new InvalidInputException('flowInfo.sha256', 'Provided file sha256 hash does not correspond to computed file hash.');
        }

        if ($input->flowInfo->submittedAt && $input->flowInfo->submittedAt->diff(new \DateTimeImmutable())->days > 0) {
            throw new InvalidInputException('flowInfo.submittedAt', 'Flow submission date must not be before now.');
        }
    }
}
