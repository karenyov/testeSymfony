<?php

namespace App\Core\Entity;

use App\Core\Repository\MatrizRepository;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: MatrizRepository::class)]
#[ORM\Table(name: "matriz", schema: "ilogix")]
class Matriz
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

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
