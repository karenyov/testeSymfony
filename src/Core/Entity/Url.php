<?php

namespace App\Core\Entity;

use App\Core\Repository\UrlRepository;
use App\Core\Entity\Funcionalidade;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UrlRepository::class)]
#[ORM\Table(name: "url", schema: "ilogix")]
class Url
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\Column(name: "route", length: 255, nullable: false)]
    private string $route;

    #[ORM\Column(name: "http_get", type: "boolean", nullable: true, options: ["default" => false])]
    private bool $httpGet;

    #[ORM\Column(name: "http_post", type: "boolean", nullable: true, options: ["default" => false])]
    private bool $httpPost;

    #[ORM\Column(name: "http_put", type: "boolean", nullable: true, options: ["default" => false])]
    private bool $httpPut;

    #[ORM\Column(name: "http_delete", type: "boolean", nullable: true, options: ["default" => false])]
    private bool $httpDelete;

    #[ORM\ManyToOne(targetEntity: Funcionalidade::class, inversedBy: 'urls')]
    #[ORM\JoinColumn(name: "funcionalidade_id", referencedColumnName: "id")]
    private Funcionalidade $funcionalidade;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getFuncionalidade(): ?Funcionalidade
    {
        return $this->funcionalidade;
    }

    public function setFuncionalidade(?Funcionalidade $funcionalidade): self
    {
        $this->funcionalidade = $funcionalidade;

        return $this;
    }

    public function getHttpGet(): bool
    {
        return $this->httpGet;
    }

    public function setHttpGet(bool $httpGet): self
    {
        $this->httpGet = $httpGet;

        return $this;
    }

    public function getHttpPost(): bool
    {
        return $this->httpPost;
    }

    public function setHttpPost(bool $httpPost): self
    {
        $this->httpPost = $httpPost;

        return $this;
    }


    public function getHttpDelete(): bool
    {
        return $this->httpDelete;
    }

    public function setHttpDelete(bool $httpDelete): self
    {
        $this->httpDelete = $httpDelete;

        return $this;
    }


    public function getHttpPut(): bool
    {
        return $this->httpPut;
    }

    public function setHttpPut(bool $httpPut): self
    {
        $this->httpPut = $httpPut;

        return $this;
    }
}
