<?php

namespace App\Core\Repository;

use App\Core\Entity\UsuarioLogAccess as Entity;
use Doctrine\Persistence\ManagerRegistry;

class UsuarioLogAccessRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entity::class);
    }
}
