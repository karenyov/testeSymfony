<?php

namespace App\Supply\Entity;

use App\Core\Entity\Empresa;
use App\Supply\Repository\PedidoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
#[ORM\Table(name: "pedido", schema: "compras")]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: "num_pedido", nullable: false)]
    private ?int $numPedido = null;

    #[ORM\Column(name: "ano_pedido", nullable: false)]
    private ?int $anoPedido = null;

    #[ORM\ManyToOne(targetEntity: Empresa::class, inversedBy: 'pedidos')]
    #[ORM\JoinColumn(name: "empresa_id", referencedColumnName: "id")]
    private Empresa $empresa;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumPedido(): ?int
    {
        return $this->numPedido;
    }

    public function setNumPedido(int $numPedido): static
    {
        $this->numPedido = $numPedido;

        return $this;
    }

    public function getAnoPedido(): ?int
    {
        return $this->anoPedido;
    }

    public function setAnoPedido(int $anoPedido): static
    {
        $this->anoPedido = $anoPedido;

        return $this;
    }

    public function getEmpresa(): ?Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(?Empresa $empresa): self
    {
        $this->empresa = $empresa;

        return $this;
    }
}
