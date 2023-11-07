<?php

namespace App\Supply\Repository;

use App\Supply\Entity\Pedido as Entity;
use App\Core\Repository\BaseRepository;

use Ramsey\Uuid\UuidInterface;

use Doctrine\Persistence\ManagerRegistry;

class PedidoRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entity::class);
    }

    public function isUnique(int $num, int $year, ?UuidInterface $id = null): ?bool
    {
        $query =  $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.numPedido = :numPedido')
            ->andWhere('p.anoPedido = :anoPedido')
            ->setParameter('numPedido', $num)
            ->setParameter('anoPedido', $year);

        if ($id !== null) {
            $query
                ->andWhere('p.id <> :id')
                ->setParameter('id', $id);
        }
        return $query->getQuery()->getOneOrNullResult() === null;
    }
}
