<?php

namespace App\Supply\Entity;

use App\Core\Entity\Empresa;
use App\Supply\Repository\PedidoRepository;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
#[ORM\Table(name: "pedido", schema: "compras")]
class Pedido
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\Column(name: "num_pedido", nullable: false)]
    private ?int $numPedido = null;

    #[ORM\Column(name: "ano_pedido", nullable: false)]
    private ?int $anoPedido = null;

    #[ORM\ManyToOne(targetEntity: Empresa::class, inversedBy: 'pedidos')]
    #[ORM\JoinColumn(name: "empresa_id", referencedColumnName: "id", nullable: false)]
    private Empresa $empresa;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getNumPedido(): ?int
    {
        return $this->numPedido;
    }

    public function setNumPedido(int $numPedido): self
    {
        $this->numPedido = $numPedido;

        return $this;
    }

    public function getAnoPedido(): ?int
    {
        return $this->anoPedido;
    }

    public function setAnoPedido(int $anoPedido): self
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
