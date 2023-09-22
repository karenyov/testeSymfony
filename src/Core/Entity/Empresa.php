<?php

namespace App\Core\Entity;

use App\Core\Repository\EmpresaRepository;
use App\Core\Entity\Matriz;
use App\Supply\Entity\Pedido;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: EmpresaRepository::class)]
#[ORM\Table(name: "empresa", schema: "ilogix")]
class Empresa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getApelido(): ?string
    {
        return $this->apelido;
    }

    public function setApelido(string $apelido): static
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
