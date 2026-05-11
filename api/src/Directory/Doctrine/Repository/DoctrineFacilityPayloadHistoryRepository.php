<?php

declare(strict_types=1);

namespace App\Directory\Doctrine\Repository;

use App\Directory\Doctrine\Entity\FacilityPayloadHistory;
use App\Directory\Enum\ContainsOperator;
use App\Directory\Enum\Order;
use App\Directory\Enum\StrictOperator;
use App\Directory\Input\SearchSiretFilters;
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

    public function getSiretBySiretNumber(string $siret): ?FacilityPayloadHistory
    {
        return $this->findOneBy([
            'siret' => $siret
        ]);
    }

    //TODO rajouter ignore
    //TODO rajouter include
    public function search(SearchSiretFilters $filters, ?array $sorting, ?array $fields, ?int $limit): array
    {
        $qb = $this->createQueryBuilder('FacilityPayloadHistory')
            ->leftJoin('FacilityPayloadHistory.address', 'address')
            ->setMaxResults($limit);

        if (null !== $filters->siret && $filters->siret->operator === ContainsOperator::opContains) {
            $qb->andWhere('FacilityPayloadHistory.siret LIKE :siret')
                ->setParameter('siret', '%'.$filters->siret->siret.'%');
        }

        if (null !== $filters->siren && $filters->siren->operator === ContainsOperator::opContains) {
            $qb->andWhere('FacilityPayloadHistory.siren LIKE :siren')
                ->setParameter('siren', '%'.$filters->siren->siren.'%');
        }

        if (null !== $filters->name && $filters->name->operator === ContainsOperator::opContains) {
            $qb->andWhere('FacilityPayloadHistory.name LIKE :name')
                ->setParameter('name', '%'.$filters->name->name.'%');
        }

        if (null !== $filters->facilityType && $filters->facilityType->operator === ContainsOperator::opContains) {
            $qb->andWhere('FacilityPayloadHistory.facilityType IN (:facilityType)')
                ->setParameter('facilityType', $filters->facilityType->entityType);
        }

        if (null !== $filters->administrativeStatus && $filters->administrativeStatus->operator === StrictOperator::opStrict) {
            $qb->andWhere('FacilityPayloadHistory.administrativeStatus = :administrativeStatus')
                ->setParameter('administrativeStatus', $filters->administrativeStatus->administrativeStatus);
        }

        if (null !== $filters->addressLines && $filters->addressLines->operator === ContainsOperator::opContains) {
            $qb
                ->andWhere(
                    $qb->expr()->orX(
                        'address.addressLine1 LIKE :addressLines',
                        'address.addressLine2 LIKE :addressLines',
                        'address.addressLine3 LIKE :addressLines',
                    )
                )
                ->setParameter('addressLines', '%'.$filters->addressLines->addressLines.'%');
        }

        if (null !== $filters->postalCode && $filters->postalCode->operator === ContainsOperator::opContains) {
            $qb
                ->andWhere('address.postalCode LIKE :postalCode')
                ->setParameter('postalCode', '%'.$filters->postalCode->postalCode.'%');
        }

        if (null !== $filters->countrySubdivision && $filters->countrySubdivision->operator === ContainsOperator::opContains) {
            $qb
                ->andWhere('address.countrySubdivision LIKE :countrySubdivision')
                ->setParameter('countrySubdivision', '%'.$filters->countrySubdivision->countrySubdivision.'%');
        }

        if (null !== $filters->locality && $filters->locality->operator === ContainsOperator::opContains) {
            $qb
                ->andWhere('address.locality LIKE :locality')
                ->setParameter('locality', '%'.$filters->locality->locality.'%');
        }

        foreach ($sorting as $sort) {
            if($sort->order === Order::ascending) {
                $qb->addOrderBy('FacilityPayloadHistory.' . $sort->field, 'ASC');
            }
            elseif($sort->order === Order::descending) {
                $qb->addOrderBy('FacilityPayloadHistory.' . $sort->field, 'DESC');
            }
        }

        foreach ($fields as $field) {
            $qb->addSelect('FacilityPayloadHistory.' . $field);
        }

        return $qb->getQuery()->getResult();
    }
}
