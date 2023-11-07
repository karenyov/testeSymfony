<?php

namespace App\Core\Request\Matriz;

use App\Core\Request\AbstractJsonRequest;
use Symfony\Component\Validator\Constraints as Assert;

class MatrizCreateRequest extends AbstractJsonRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public readonly string $nome;

    public function getNome(): string
    {
        return $this->nome;
    }
}
