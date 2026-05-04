<?php

declare(strict_types=1);

namespace App\Flow\Doctrine\Repository;

use App\Flow\Doctrine\Entity\Flow;
use App\Flow\Input\SearchFlowFilters;
use App\Flow\Repository\FlowRepository;
use App\User\Doctrine\Entity\ApiConsumer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Flow>
 */
final class DoctrineFlowRepository extends ServiceEntityRepository implements FlowRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flow::class);
    }

    public function findById(string $id): ?Flow
    {
        return $this->find($id);
    }

    public function getFlow(string $id, string $ownerId): ?Flow
    {
        return $this->findOneBy([
            'flowId' => $id,
            'sentBy' => $ownerId,
        ]);
    }

    public function search(SearchFlowFilters $filters, int $limit, ApiConsumer $owner): array
    {
        $qb = $this->createQueryBuilder('flow')
            ->andWhere('flow.sentBy = :owner')
            ->setParameter('owner', $owner)
            ->orderBy('flow.updatedAt', 'ASC')
            ->setMaxResults($limit);

        if (null !== $filters->updatedAfterAsDateTime()) {
            $qb->andWhere('flow.updatedAt > :updatedAfter')
                ->setParameter('updatedAfter', $filters->updatedAfterAsDateTime());
        }

        if (null !== $filters->updatedBeforeAsDateTime()) {
            $qb->andWhere('flow.updatedAt <= :updatedBefore')
                ->setParameter('updatedBefore', $filters->updatedBeforeAsDateTime());
        }

        if (count($filters->processingRule ?? []) > 0) {
            $qb->andWhere('flow.processingRule IN (:processingRules)')
                ->setParameter('processingRules', $filters->processingRule);
        }

        if (count($filters->flowType ?? []) > 0) {
            $qb->andWhere('flow.flowType IN (:flowTypes)')
                ->setParameter('flowTypes', $filters->flowType);
        }

        if (count($filters->flowDirection ?? []) > 0) {
            $qb->andWhere('flow.flowDirection IN (:flowDirections)')
                ->setParameter('flowDirections', $filters->flowDirection);
        }

        if (null !== $filters->trackingId) {
            $qb->andWhere('flow.trackingId = :trackingId')
                ->setParameter('trackingId', $filters->trackingId);
        }

        if (null !== $filters->ackStatus) {
            $qb->join('flow.acknowledgement', 'a')
                ->andWhere('a.status = :ackStatus')
                ->setParameter('ackStatus', $filters->ackStatus);
        }

        return $qb->getQuery()->getResult();
    }
}
