<?php

declare(strict_types=1);

namespace App\Flow\Doctrine\Entity;

use App\Flow\Enum\AcknowledgementDetailLevel;
use App\Flow\Enum\ReasonCode;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class AcknowledgementDetail
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Acknowledgement::class)]
        #[ORM\JoinColumn(nullable: false)]
        private Acknowledgement $acknowledgement,

        #[ORM\Column]
        private AcknowledgementDetailLevel $level,

        /** Item on which the error refers */
        #[ORM\Column]
        private string $item,

        /** A predefined set of reason code values + ability to extend this set */
        #[ORM\Column]
        private ReasonCode|string $reasonCode,

        #[ORM\Column]
        private string $reasonMessage,
    ) {
        $this->id = Uuid::v7()->toString();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAcknowledgement(): Acknowledgement
    {
        return $this->acknowledgement;
    }

    public function getLevel(): AcknowledgementDetailLevel
    {
        return $this->level;
    }

    public function getItem(): string
    {
        return $this->item;
    }

    public function getReasonCode(): ReasonCode|string
    {
        return $this->reasonCode;
    }

    public function getReasonMessage(): string
    {
        return $this->reasonMessage;
    }
}
