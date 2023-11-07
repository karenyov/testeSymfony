<?php

namespace App\Core\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Entity>
 *
 * @method Entity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entity[]    findAll()
 * @method Entity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class  BaseRepository extends ServiceEntityRepository
{
    const ENCRYPTION_SQL = '%ENCRYPTION_SQL%';
    protected EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
        $this->entityManager = $this->getEntityManager();
    }

    public function save($entity): self
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $this;
    }

    public function remove($entity): self
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
        return $this;
    }

    public function update($entity): self
    {
        $this->entityManager->flush();
        return $this;
    }
}
