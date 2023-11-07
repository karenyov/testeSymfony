<?php

namespace App\Core\Request\Usuario;

use App\Core\Request\AbstractJsonRequest;
use Symfony\Component\Validator\Constraints as Assert;

class UsuarioUpdateRequest extends AbstractJsonRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public readonly string $nome;

    #[Assert\NotBlank]
    public readonly string $grupoId;

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getGrupoId(): string
    {
        return $this->grupoId;
    }
}
