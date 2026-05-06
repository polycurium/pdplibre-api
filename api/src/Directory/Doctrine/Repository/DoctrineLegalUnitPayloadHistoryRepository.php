<?php

declare(strict_types=1);

namespace App\Directory\Doctrine\Repository;

use App\Directory\Doctrine\Entity\LegalUnitPayloadHistory;
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
}
