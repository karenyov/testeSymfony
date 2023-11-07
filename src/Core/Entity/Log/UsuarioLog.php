<?php

namespace App\Core\Entity\Log;

use App\Core\Repository\Log\UsuarioLogRepository;
use App\Core\Entity\Log\BaseLog;

use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioLogRepository::class)]
#[ORM\Table(name: "usuario_log", schema: "ilogix")]
class UsuarioLog extends BaseLog
{
    #[ORM\Column(name: "usuario_id", type: "uuid")]
    private UuidInterface $usuarioId;

    #[ORM\Column(name: "grupo_id", type: "uuid", nullable: true)]
    private UuidInterface $grupoId;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nome = null;

    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private ?string $email;

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsuarioId(): ?UuidInterface
    {
        return $this->usuarioId;
    }

    public function setUsuarioId(?UuidInterface $usuarioId): self
    {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    public function getGrupoId(): ?UuidInterface
    {
        return $this->grupoId;
    }

    public function setGrupoId(?UuidInterface $grupoId): self
    {
        $this->grupoId = $grupoId;

        return $this;
    }
}
