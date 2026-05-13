<?php

declare(strict_types=1);

namespace App\Directory\ValueObjects;

use App\Directory\Doctrine\Entity\B2gAdditionalData;

final class B2gAdditionalDataOutput
{
    public ?bool $pm = null;
    public ?bool $pmOnly = null;
    public ?bool $managesPaymentStatus = null;
    public ?bool $managesLegalCommitmentCode = null;
    public ?bool $managesLegalCommitmentOrServiceCode = null;
    public ?bool $serviceCodeStatus = null;

    public static function fromEntity(B2gAdditionalData $b2gAdditionalData, ?array $fields = null): self
    {
        $self = new self();

        $returnAll = !$fields;

        if ($returnAll || in_array('pmStatus', $fields, true)) {
            $self->pm = $b2gAdditionalData->getPm();
        }

        if ($returnAll || in_array('pmOnly', $fields, true)) {
            $self->pmOnly = $b2gAdditionalData->getPmOnly();
        }

        if ($returnAll || in_array('managesPaymentStatus', $fields, true)) {
            $self->managesPaymentStatus = $b2gAdditionalData->getManagesPaymentStatus();
        }

        if ($returnAll || in_array('managesLegalCommitmentCode', $fields, true)) {
            $self->managesLegalCommitmentCode = $b2gAdditionalData->getManagesLegalCommitmentCode();
        }

        if ($returnAll || in_array('managesLegalCommitmentOrServiceCode', $fields, true)) {
            $self->managesLegalCommitmentOrServiceCode = $b2gAdditionalData->getManagesLegalCommitmentOrServiceCode();
        }

        if ($returnAll || in_array('serviceCodeStatus', $fields, true)) {
            $self->serviceCodeStatus = $b2gAdditionalData->getServiceCodeStatus();
        }

        return $self;
    }
}
