<?php

namespace App\Core\Entity\Log;

use App\Core\Repository\Log\EmpresaLogRepository;
use App\Core\Entity\Log\BaseLog;

use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpresaLogRepository::class)]
#[ORM\Table(name: "empresa_log", schema: "ilogix")]
class EmpresaLog extends BaseLog
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apelido = null;

    #[ORM\Column(name: "empresa_id", type: "uuid")]
    private UuidInterface $empresaId;

    #[ORM\Column(name: "matriz_id", nullable: true, type: "uuid")]
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

    public function getApelido(): ?string
    {
        return $this->apelido;
    }

    public function setApelido(string $apelido): self
    {
        $this->apelido = $apelido;

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

    public function getEmpresaId(): ?UuidInterface
    {
        return $this->empresaId;
    }

    public function setEmpresaId(?UuidInterface $empresaId): self
    {
        $this->empresaId = $empresaId;

        return $this;
    }
}
