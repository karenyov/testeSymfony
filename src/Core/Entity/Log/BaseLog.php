<?php

namespace App\Core\Entity\Log;

use App\Core\Entity\Usuario;
use App\Core\Enum\Operacao;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;

#[MappedSuperclass]
abstract class BaseLog
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\Column(name: "log_data", type: 'datetime', nullable: false)]
    private \DateTimeImmutable $logData;

    #[ORM\Column(name: "log_operacao", nullable: false, type: "operacao", length: 1)]
    private Operacao  $logOperacao;

    #[ORM\ManyToOne(targetEntity: Usuario::class, fetch: 'LAZY')]
    #[ORM\JoinColumn(name: "log_usuario_id", referencedColumnName: "id", nullable: false)]
    private Usuario $logUsuario;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getLogData(): \DateTimeImmutable
    {
        return $this->logData;
    }

    public function setLogData(\DateTimeImmutable $logData): static
    {
        $this->logData = $logData;

        return $this;
    }

    public function getLogOperacao(): Operacao
    {
        return $this->logOperacao;
    }

    public function setLogOperacao(Operacao $logOperacao): self
    {
        $this->logOperacao = $logOperacao;

        return $this;
    }

    public function getLogUsuario(): ?Usuario
    {
        return $this->logUsuario;
    }

    public function setLogUsuario(?Usuario $logUsuario): self
    {
        $this->logUsuario = $logUsuario;

        return $this;
    }
}
