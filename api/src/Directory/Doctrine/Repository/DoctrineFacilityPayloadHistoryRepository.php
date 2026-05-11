<?php

declare(strict_types=1);

namespace App\Directory\Doctrine\Repository;

use App\Directory\Doctrine\Entity\FacilityPayloadHistory;
use App\Directory\Repository\FacilityPayloadHistoryRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FacilityPayloadHistory>
 */
final class DoctrineFacilityPayloadHistoryRepository extends ServiceEntityRepository implements FacilityPayloadHistoryRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FacilityPayloadHistory::class);
    }

    public function getSiretByIdInstance(int $id): ?FacilityPayloadHistory
    {
        return $this->findOneBy([
            'idInstance' => $id
        ]);
    }

    public function getSiretBySirenNumber(string $siret): ?FacilityPayloadHistory
    {
        return $this->findOneBy([
            'siret' => $siret
        ]);
    }
//
//    //TODO rajouter ignore
//    public function search(SearchSirenFilters $filters, ?array $sorting, ?array $fields, ?int $limit): array
//    {
//        $qb = $this->createQueryBuilder('FacilityPayloadHistory')
//            ->setMaxResults($limit);
//
//        if (null !== $filters->siren && $filters->siren->operator === ContainsOperator::opContains) {
//            $qb->andWhere('FacilityPayloadHistory.siren IN (:siren)')
//                ->setParameter('siren', $filters->siren->siren);
//        }
//
//        if (null !== $filters->businessName && $filters->businessName->operator === ContainsOperator::opContains) {
//            $qb->andWhere('FacilityPayloadHistory.businessName IN (:businessName)')
//                ->setParameter('businessName', $filters->businessName->businessName);
//        }
//
//        if (null !== $filters->entityType && $filters->entityType->operator === StrictOperator::opStrict) {
//            $qb->andWhere('FacilityPayloadHistory.entityType IN (:entityType)')
//                ->setParameter('entityType', $filters->entityType->entityType);
//        }
//
//        if (null !== $filters->administrativeStatus && $filters->administrativeStatus->operator === StrictOperator::opStrict) {
//            $qb->andWhere('FacilityPayloadHistory.administrativeStatus IN (:administrativeStatus)')
//                ->setParameter('administrativeStatus', $filters->administrativeStatus->administrativeStatus);
//        }
//
//        foreach ($sorting as $sort) {
//            if($sort->order === Order::ascending) {
//                $qb->addOrderBy('FacilityPayloadHistory' . $sort->field, 'ASC');
//            }
//            elseif($sort->order === Order::descending) {
//                $qb->addOrderBy('FacilityPayloadHistory' . $sort->field, 'DESC');
//            }
//        }
//
//        foreach ($fields as $field) {
//            $qb->addSelect('FacilityPayloadHistory.' . $field);
//        }
//
//        return $qb->getQuery()->getResult();
//    }
}
