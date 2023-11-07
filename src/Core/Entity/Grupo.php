<?php

namespace App\Core\Entity;

use App\Core\Entity\Usuario;
use App\Core\Entity\Funcionalidade;
use App\Core\Repository\GrupoRepository;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: GrupoRepository::class)]
#[ORM\Table(name: "grupo", schema: "ilogix")]
class Grupo
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\OneToMany(targetEntity: Usuario::class, mappedBy: 'grupo')]
    private Collection $usuarios;

    #[ORM\ManyToMany(targetEntity: Funcionalidade::class, inversedBy: 'grupos')]
    #[ORM\JoinTable(name: "ilogix.grupo_funcionalidade")]
    private ?Collection $funcionalidades;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->funcionalidades = new ArrayCollection();
    }

    public function getFuncionalidades(): Collection
    {
        return $this->funcionalidades;
    }

    public function addFuncionalidade(?Funcionalidade $funcionalidade): self
    {
        if (!$this->funcionalidades->contains($funcionalidade)) {
            $this->funcionalidades[] = $funcionalidade;
        }

        return $this;
    }

    public function removeFuncionalidade(Funcionalidade $funcionalidade): self
    {
        $this->funcionalidades->removeElement($funcionalidade);

        return $this;
    }

    public function getUsuarios(): Collection
    {
        return $this->usuarios;
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
}
