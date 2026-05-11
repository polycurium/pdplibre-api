<?php

declare(strict_types=1);

namespace App\Directory\ValueObjects;

use App\Directory\Doctrine\Entity\B2gAdditionalData;

final readonly class B2gAdditionalDataOutput
{
    public function __construct(
        public bool $pm,
        public bool $pmOnly,
        public bool $managesPaymentStatus,
        public bool $managesLegalCommitmentCode,
        public bool $managesLegalCommitmentOrServiceCode,
        public bool $serviceCodeStatus
    ) {
    }

    public static function fromEntity(B2gAdditionalData $b2gAdditionalData): self
    {
        return new self(
            pm: $b2gAdditionalData->getPm(),
            pmOnly: $b2gAdditionalData->getPmOnly(),
            managesPaymentStatus: $b2gAdditionalData->getManagesPaymentStatus(),
            managesLegalCommitmentCode: $b2gAdditionalData->getManagesLegalCommitmentCode(),
            managesLegalCommitmentOrServiceCode: $b2gAdditionalData->getManagesLegalCommitmentOrServiceCode(),
            serviceCodeStatus: $b2gAdditionalData->getServiceCodeStatus(),
        );
    }
}
