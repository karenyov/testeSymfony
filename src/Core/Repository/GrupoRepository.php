<?php

namespace App\Core\Repository;

use App\Core\Entity\Grupo as Entity;
use Doctrine\Persistence\ManagerRegistry;

class GrupoRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entity::class);
    }
}
