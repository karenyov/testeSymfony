<?php

namespace App\Core\Entity\Log;

use App\Core\Repository\Log\MatrizLogRepository;
use App\Core\Entity\Log\BaseLog;

use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatrizLogRepository::class)]
#[ORM\Table(name: "matriz_log", schema: "ilogix")]
class MatrizLog extends BaseLog
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nome = null;

    #[ORM\Column(name: "matriz_id", type: "uuid")]
    private UuidInterface $matrizId;

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getMatrizId(): ?UuidInterface
    {
        return $this->matrizId;
    }

    public function setMatrizId(?UuidInterface $matrizId): self
    {
        $this->matrizId = $matrizId;

        return $this;
    }
}
