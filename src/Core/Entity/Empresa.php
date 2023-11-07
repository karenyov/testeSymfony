<?php

namespace App\Core\Entity;

use App\Core\Repository\EmpresaRepository;
use App\Core\Entity\Matriz;
use App\Supply\Entity\Pedido;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: EmpresaRepository::class)]
#[ORM\Table(name: "empresa", schema: "ilogix")]
class Empresa
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $nome = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $apelido = null;

    #[ORM\OneToMany(targetEntity: Pedido::class, mappedBy: 'empresa')]
    private Collection $pedidos;

    #[ORM\ManyToOne(targetEntity: Matriz::class, inversedBy: 'empresas')]
    #[ORM\JoinColumn(name: "matriz_id", referencedColumnName: "id")]
    private Matriz $matriz;

    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
    }

    public function getPedidos(): Collection
    {
        return $this->pedidos;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

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

    public function getMatriz(): ?Matriz
    {
        return $this->matriz;
    }

    public function setMatriz(?Matriz $matriz): self
    {
        $this->matriz = $matriz;

        return $this;
    }
}
