<?php

namespace App\User\Repository;

use App\User\Doctrine\Entity\ApiConsumer;

interface UserRepository
{
    public function upgradePassword(ApiConsumer $user, string $newHashedPassword): void;
}
