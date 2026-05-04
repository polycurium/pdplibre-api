<?php

namespace App\Common\EventListener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

/**
 * If used with DoctrineBundle, this listener allows automatic resolutions of the "repositoryClass"
 * option in entities when these classes are referenced as interfaces instead of concrete implementations.
 */
#[AsDoctrineListener('loadClassMetadata')]
final class DoctrineRepositoryInterfaceListener
{
    /**
     * @var array<EntityRepository>
     */
    private array $repositories;

    public function __construct(
        #[AutowireIterator(tag: 'doctrine.repository_service')]
        iterable $repositories,
    ) {
        foreach ($repositories as $repository) {
            $this->addRepository($repository);
        }
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $metadata = $eventArgs->getClassMetadata();

        $repoClass = $metadata->customRepositoryClassName;
        if (!$repoClass) {
            // No repository to configure
            return;
        }

        if (interface_exists($repoClass)) {
            $finalRepoClass = null;
            foreach ($this->repositories as $repository) {
                if ($repository instanceof $repoClass) {
                    if ($finalRepoClass) {
                        throw new \RuntimeException(sprintf('Two implementations exist for interface "%s".', $repoClass));
                    }
                    $finalRepoClass = $repository::class;
                }
            }
            if ($finalRepoClass) {
                $metadata->customRepositoryClassName = $finalRepoClass;
            }
            // No implementation found: Doctrine will throw their own exception.
        }
    }

    private function addRepository(EntityRepository $repository): void
    {
        $this->repositories[] = $repository;
    }
}
