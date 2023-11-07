<?php

namespace App\Core\Repository;

use App\Core\Entity\Matriz as Entity;
use Doctrine\Persistence\ManagerRegistry;

class MatrizRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entity::class);
    }
}
