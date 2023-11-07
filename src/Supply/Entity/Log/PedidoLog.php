<?php

namespace App\Supply\Entity\Log;

use App\Supply\Repository\Log\PedidoLogRepository;
use App\Core\Entity\Log\BaseLog;

use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoLogRepository::class)]
#[ORM\Table(name: "pedido_log", schema: "compras")]
class PedidoLog extends BaseLog
{
    #[ORM\Column(name: "num_pedido", nullable: true)]
    private ?int $numPedido = null;

    #[ORM\Column(name: "ano_pedido", nullable: true)]
    private ?int $anoPedido = null;

    #[ORM\Column(name: "empresa_id", nullable: true,  type: "uuid")]
    private UuidInterface $empresaId;

    #[ORM\Column(name: "pedido_id",  type: "uuid")]
    private UuidInterface $pedidoId;

    public function getNumPedido(): ?UuidInterface
    {
        return $this->numPedido;
    }

    public function setNumPedido(UuidInterface $numPedido): self
    {
        $this->numPedido = $numPedido;

        return $this;
    }

    public function getAnoPedido(): ?UuidInterface
    {
        return $this->anoPedido;
    }

    public function setAnoPedido(UuidInterface $anoPedido): self
    {
        $this->anoPedido = $anoPedido;

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

    public function getPedidoId(): ?UuidInterface
    {
        return $this->pedidoId;
    }

    public function setPedidoId(?UuidInterface $pedidoId): self
    {
        $this->pedidoId = $pedidoId;

        return $this;
    }
}
