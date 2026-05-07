<?php

declare(strict_types=1);

namespace App\Directory\Doctrine\Repository;

use App\Directory\Doctrine\Entity\LegalUnitPayloadHistory;
use App\Directory\Enum\ContainsOperator;
use App\Directory\Enum\Order;
use App\Directory\Enum\StrictOperator;
use App\Directory\Input\SearchSirenFilters;
use App\Directory\Repository\LegalUnitPayloadHistoryRepository;
use App\User\Doctrine\Entity\ApiConsumer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LegalUnitPayloadHistory>
 */
final class DoctrineLegalUnitPayloadHistoryRepository extends ServiceEntityRepository implements LegalUnitPayloadHistoryRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LegalUnitPayloadHistory::class);
    }

    public function getSirenByIdInstance(int $id): ?LegalUnitPayloadHistory
    {
        return $this->findOneBy([
            'idInstance' => $id
        ]);
    }

    public function getSirenBySirenNumber(string $siren): ?LegalUnitPayloadHistory
    {
        return $this->findOneBy([
            'siren' => $siren
        ]);
    }

    //TODO rajouter ignore
    public function search(SearchSirenFilters $filters, ?array $sorting, ?array $fields, ?int $limit): array
    {
        $qb = $this->createQueryBuilder('legalUnitPayloadHistory')
            ->setMaxResults($limit);

        if (null !== $filters->siren && $filters->siren->operator === ContainsOperator::opContains) {
            $qb->andWhere('legalUnitPayloadHistory.siren IN (:siren)')
                ->setParameter('siren', $filters->siren->siren);
        }

        if (null !== $filters->businessName && $filters->businessName->operator === ContainsOperator::opContains) {
            $qb->andWhere('legalUnitPayloadHistory.businessName IN (:businessName)')
                ->setParameter('businessName', $filters->businessName->businessName);
        }

        if (null !== $filters->entityType && $filters->entityType->operator === StrictOperator::opStrict) {
            $qb->andWhere('legalUnitPayloadHistory.entityType IN (:entityType)')
                ->setParameter('entityType', $filters->entityType->entityType);
        }

        if (null !== $filters->administrativeStatus && $filters->administrativeStatus->operator === StrictOperator::opStrict) {
            $qb->andWhere('legalUnitPayloadHistory.administrativeStatus IN (:administrativeStatus)')
                ->setParameter('administrativeStatus', $filters->administrativeStatus->administrativeStatus);
        }

        foreach ($sorting as $sort) {
            if($sort->order === Order::ascending) {
                $qb->addOrderBy('legalUnitPayloadHistory' . $sort->field, 'ASC');
            }
            elseif($sort->order === Order::descending) {
                $qb->addOrderBy('legalUnitPayloadHistory' . $sort->field, 'DESC');
            }
        }

        foreach ($fields as $field) {
            $qb->addSelect('legalUnitPayloadHistory.' . $field);
        }

        return $qb->getQuery()->getResult();
    }
}
