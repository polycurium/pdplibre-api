<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Orbitale\Component\ArrayFixture\ArrayFixture;
use App\User\Doctrine\Entity\ApiConsumer;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

final class UserFixtures extends ArrayFixture implements ORMFixtureInterface
{
    public const string DEFAULT_EMAIL = 'demo@example.com';

    public function __construct(
        private readonly PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
        parent::__construct();
    }

    protected function getEntityClass(): string
    {
        return ApiConsumer::class;
    }

    protected function getReferencePrefix(): ?string
    {
        return 'user-';
    }

    protected function getMethodNameForReference(): string
    {
        return 'getEmail';
    }

    protected function getObjects(): iterable
    {
        $hasher = $this->passwordHasherFactory->getPasswordHasher($this->getEntityClass());

        yield [
            'id' => 'eceb8bfc-a32a-45e0-9101-533552c6e741',
            'email' => self::DEFAULT_EMAIL,
            'password' => $hasher->hash('foobar'),
        ];
        yield [
            'id' => '09b1f712-f727-4199-bd5e-a02f8f0db1d7',
            'email' => 'other@example.com',
            'password' => $hasher->hash('foobar'),
        ];
    }
}
