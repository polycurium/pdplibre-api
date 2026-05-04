<?php

declare(strict_types=1);

namespace App\Flow\Doctrine\Entity;

use App\Flow\Enum\FlowAckStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity()]
class Acknowledgement
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    public function __construct(
        #[ORM\Column]
        private FlowAckStatus $status,

        /** @var AcknowledgementDetail[] */
        #[ORM\OneToMany(targetEntity: AcknowledgementDetail::class, mappedBy: 'acknowledgement', cascade: ['persist'])]
        private Collection $details = new ArrayCollection(),
    ) {
        $this->id = Uuid::v7()->toString();
    }

    public static function pending(): self
    {
        return new self(FlowAckStatus::Pending);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): FlowAckStatus
    {
        return $this->status;
    }

    /**
     * @return Collection<AcknowledgementDetail>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function markOk(): void
    {
        if (FlowAckStatus::Ok === $this->status) {
            return;
        }

        if (FlowAckStatus::Pending !== $this->status) {
            throw new \RuntimeException(\sprintf('Cannot change acknowledgement from "%s" to "Ok".', $this->status->value));
        }

        $this->status = FlowAckStatus::Ok;
    }

    /**
     * @param AcknowledgementDetail[] $details
     */
    public function markError(array $details): void
    {
        if (FlowAckStatus::Error === $this->status) {
            return;
        }

        if (FlowAckStatus::Pending !== $this->status) {
            throw new \RuntimeException(\sprintf('Cannot change acknowledgement from "%s" to "Error".', $this->status->value));
        }

        if (!\count($details)) {
            throw new \InvalidArgumentException('At least one acknowledgement detail is required when marking as an error.');
        }

        $this->status = FlowAckStatus::Error;

        foreach ($details as $detail) {
            $this->details->add($detail);
        }
    }
}
