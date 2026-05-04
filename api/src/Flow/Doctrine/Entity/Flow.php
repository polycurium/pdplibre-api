<?php

declare(strict_types=1);

namespace App\Flow\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Flow\Enum\FlowDirection;
use App\Flow\Enum\FlowProcessingRuleSource;
use App\Flow\Enum\FlowProfile;
use App\Flow\Enum\FlowSyntax;
use App\Flow\Enum\FlowType;
use App\Flow\Enum\ProcessingRule;
use App\Flow\Repository\FlowRepository;
use App\Flow\ValueObjects\ValidFlowInput;
use App\User\Doctrine\Entity\ApiConsumer;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(
    repositoryClass: FlowRepository::class,
)]
class Flow
{
    public const string FILE_HASH_REGEX = '~^[a-f0-9]{64}$~iuU';

    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $flowId;

    /**
     * The flow submission date and time (the date and time when the flow was created on the system).
     */
    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeInterface $submittedAt;

    /**
     * The last update date and time of the flow. When the flow is submitted updatedAt is equal to submittedAt. When the flow acknowledgment status is changed updatedAt date and time is updated.
     */
    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeInterface $updatedAt;

    #[ORM\Column(type: 'text')]
    private string $trackingId;

    #[ORM\Column]
    private FlowType $flowType;

    #[ORM\Column]
    private ProcessingRule $processingRule;

    #[ORM\Column]
    private FlowProcessingRuleSource $processingRuleSource;

    /**
     * Direction of the flow:
     *  - `In`: Incoming flow, from the PDP to the OD
     *  - `Out`: Outgoing flow, from the OD to the PDP.
     */
    #[ORM\Column]
    private FlowDirection $flowDirection;

    /**
     * Syntax of the original file belonging to a flow.
     */
    #[ORM\Column]
    private FlowSyntax $flowSyntax;

    #[ORM\Column]
    private FlowProfile $flowProfile;

    #[ORM\Column(name: 'file_sha256')]
    private string $sha256;

    #[ORM\Column(name: 'file_name')]
    private string $name;

    #[ORM\OneToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Acknowledgement $acknowledgement;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    private ApiConsumer $issuedBy;

    private function __construct()
    {
        $this->flowId = Uuid::v7()->toString();
    }

    public static function fromCreateApi(ApiConsumer $user, ValidFlowInput $validInput): self
    {
        $self = new self();

        $self->issuedBy = $user;
        $self->submittedAt = $validInput->submittedAt;
        $self->updatedAt = $validInput->submittedAt;
        $self->trackingId = $validInput->trackingId;
        $self->flowType = FlowType::PendingQualification;
        $self->processingRule = $validInput->processingRule;
        $self->processingRuleSource = $validInput->processingRuleSource;
        $self->flowDirection = FlowDirection::Out;
        $self->flowSyntax = $validInput->flowSyntax;
        $self->flowProfile = $validInput->flowProfile;
        $self->acknowledgement = Acknowledgement::pending();
        $self->sha256 = $validInput->sha256;
        $self->name = $self->flowId.'-'.$validInput->name;

        return $self;
    }

    public function getId(): string
    {
        return $this->getFlowId();
    }

    public function getFlowId(): string
    {
        return $this->flowId;
    }

    public function getSubmittedAt(): \DateTimeInterface
    {
        return $this->submittedAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getTrackingId(): string
    {
        return $this->trackingId;
    }

    public function getFlowType(): FlowType
    {
        return $this->flowType;
    }

    public function getProcessingRule(): ProcessingRule
    {
        return $this->processingRule;
    }

    public function getProcessingRuleSource(): FlowProcessingRuleSource
    {
        return $this->processingRuleSource;
    }

    public function getFlowDirection(): FlowDirection
    {
        return $this->flowDirection;
    }

    public function getFlowSyntax(): FlowSyntax
    {
        return $this->flowSyntax;
    }

    public function getFlowProfile(): FlowProfile
    {
        return $this->flowProfile;
    }

    public function getAcknowledgement(): Acknowledgement
    {
        return $this->acknowledgement;
    }

    public function getSha256(): string
    {
        return $this->sha256;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIssuedBy(): ApiConsumer
    {
        return $this->issuedBy;
    }

    public function markAcknowledgementOk(\DateTimeInterface $now): void
    {
        $this->acknowledgement->markOk();
        $this->updatedAt = $now;
    }

    /**
     * @param AcknowledgementDetail[] $details
     */
    public function markAcknowledgementError(array $details, \DateTimeInterface $now): void
    {
        $this->acknowledgement->markError($details);
        $this->updatedAt = $now;
    }
}
