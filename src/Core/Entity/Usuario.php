<?php

namespace App\Core\Entity;

use App\Core\Entity\Grupo;
use App\Core\Repository\UsuarioRepository;
use App\Core\Security\Crypto;
use App\Core\Entity\Traits\UsuarioLogAccessTrait;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[ORM\Table(name: "usuario", schema: "ilogix")]
class Usuario extends Crypto implements UserInterface, PasswordAuthenticatedUserInterface
{
    use UsuarioLogAccessTrait;

    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    #[ORM\Column(name: "senha", type: 'string', length: 255)]
    private ?string $password;

    #[ORM\ManyToOne(targetEntity: Grupo::class, inversedBy: 'usuarios', fetch: 'LAZY')]
    #[ORM\JoinColumn(name: "grupo_id", referencedColumnName: "id", nullable: false)]
    private Grupo $grupo;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getGrupo(): Grupo
    {
        return $this->grupo;
    }

    public function setGrupo(Grupo $grupo): self
    {
        $this->grupo = $grupo;

        return $this;
    }

    public function getNome(): string
    {
        return $this->decryptData($this->nome);
    }

    public function setNome(string $nome): self
    {
        $this->nome = $this->encryptData($nome);

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->getEmail();
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return [];
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
