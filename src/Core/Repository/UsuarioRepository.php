<?php

namespace App\Core\Repository;

use App\Core\Entity\Usuario as Entity;
use App\Core\Security\Crypto;

use Ramsey\Uuid\UuidInterface;

use Doctrine\Persistence\ManagerRegistry;

class UsuarioRepository extends BaseRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly Crypto  $crypto
    ) {
        parent::__construct($registry, Entity::class);
    }

    public function isUnique(string $email, ?UuidInterface $id = null): ?bool
    {
        $query =  $this->createQueryBuilder('u')
            ->select('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email);

        if ($id !== null) {
            $query
                ->andWhere('u.id <> :id')
                ->setParameter('id', $id);
        }
        // $dql = $query->getDQL();
        return $query->getQuery()->getOneOrNullResult() === null;
    }

    public function findByEmail(string $email): ?Entity
    {
        $query =  $this->createQueryBuilder('u')
            ->select('u')
            ->andWhere('u.email = :email')

            // ->andWhere('AES_DECRYPT_FROM_BASE64(u.email, :key) = :email')
            // ->setParameter('key', self::ENCRYPTION_SQL)
            ->setParameter('email', $email);

        return $query->getQuery()->getOneOrNullResult();
    }

    public function hasAccessToUrl(UuidInterface $id, string $url, string $method): ?bool
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT u.id
            FROM ilogix.usuario u
            JOIN ilogix.grupo_funcionalidade gf ON gf.grupo_id = u.grupo_id
            JOIN ilogix.funcionalidade f ON f.id = gf.funcionalidade_id
            JOIN ilogix.url ur ON ur.funcionalidade_id = f.id
            WHERE u.id = :id AND ur.route = :url 
            AND (
                (:method = \'GET\' AND ur.http_get = 1)
                OR (:method = \'POST\' AND ur.http_post = 1)
                OR (:method = \'PUT\' AND ur.http_put = 1)
                OR (:method = \'DELETE\' AND ur.http_delete = 1)
            )';
        $result = $conn->executeQuery($sql, ['id' => $id, 'url' => $url, 'method' => $method])->rowCount();

        return $result;
    }
}
