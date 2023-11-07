<?php

namespace App\Core\Request\Usuario;

use App\Core\Request\AbstractJsonRequest;
use App\Core\Validator\Constraints\Usuario\UsuarioUnique;

use Symfony\Component\Validator\Constraints as Assert;

#[UsuarioUnique]
class UsuarioCreateRequest extends AbstractJsonRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public readonly string $nome;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type('string')]
    #[Assert\Email]
    public readonly string $email;

    #[Assert\NotBlank]
    public readonly string $grupoId;

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getGrupoId(): string
    {
        return $this->grupoId;
    }
}
