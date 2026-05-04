<?php

namespace App\User\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\User\Doctrine\Entity\ApiConsumer;
use App\User\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<ApiConsumer>
 */
final class DoctrineUserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiConsumer::class);
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof ApiConsumer) {
            throw new UnsupportedUserException(\sprintf('Expected an instance of "%s", got "%s" instead.', ApiConsumer::class, $user::class));
        }

        $user->updatePassword($newHashedPassword);
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
    }
}
