<?php

namespace App\Core\Repository;

use App\Core\Entity\Funcionalidade as Entity;
use Doctrine\Persistence\ManagerRegistry;

class FuncionalidadeRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entity::class);
    }
}
