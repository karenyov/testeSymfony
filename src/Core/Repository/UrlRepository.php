<?php

namespace App\Core\Repository;

use App\Core\Entity\Url as Entity;
use Doctrine\Persistence\ManagerRegistry;

class UrlRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entity::class);
    }
}
