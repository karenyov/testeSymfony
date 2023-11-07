<?php

namespace App\Supply\Repository\Log;

use App\Core\Repository\BaseRepository;
use App\Supply\Entity\Log\PedidoLog as Entity;

use Doctrine\Persistence\ManagerRegistry;

class PedidoLogRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entity::class);
    }
}
