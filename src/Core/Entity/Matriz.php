<?php

namespace App\Core\Entity;

use App\Core\Repository\MatrizRepository;
use App\Core\Entity\Empresa;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: MatrizRepository::class)]
#[ORM\Table(name: "matriz", schema: "ilogix")]
class Matriz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\OneToMany(targetEntity: Empresa::class, mappedBy: 'matriz')]
    private Collection $empresas;

    public function __construct()
    {
        $this->empresas = new ArrayCollection();
    }

    public function getEmpresas(): Collection
    {
        return $this->empresas;
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
}
