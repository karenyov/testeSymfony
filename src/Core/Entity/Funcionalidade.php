<?php

namespace App\Core\Entity;

use App\Core\Entity\Grupo;
use App\Core\Repository\FuncionalidadeRepository;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: FuncionalidadeRepository::class)]
#[ORM\Table(name: "funcionalidade", schema: "ilogix")]
class Funcionalidade
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $nome = null;

    #[ORM\ManyToMany(targetEntity: Grupo::class, mappedBy: 'funcionalidades')]
    private Collection $grupos;

    #[ORM\OneToMany(targetEntity: Url::class, mappedBy: 'funcionalidade')]
    private Collection $urls;

    public function __construct()
    {
        $this->grupos = new ArrayCollection();
        $this->urls = new ArrayCollection();
    }

    public function getGrupos(): Collection
    {
        return $this->grupos;
    }

    public function getUrls(): Collection
    {
        return $this->urls;
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
