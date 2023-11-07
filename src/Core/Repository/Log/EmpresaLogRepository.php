<?php

namespace App\Core\Repository\Log;

use App\Core\Repository\BaseRepository;
use App\Core\Entity\Log\EmpresaLog as Entity;

use Doctrine\Persistence\ManagerRegistry;

class EmpresaLogRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entity::class);
    }
}
