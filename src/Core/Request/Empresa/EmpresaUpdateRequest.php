<?php

namespace App\Core\Request\Empresa;

use App\Core\Request\AbstractJsonRequest;
use Symfony\Component\Validator\Constraints as Assert;

class EmpresaUpdateRequest extends AbstractJsonRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public readonly string $nome;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public readonly string $apelido;

    #[Assert\NotBlank]
    public readonly string $matrizId;

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getApelido(): string
    {
        return $this->apelido;
    }

    public function getMatrizId(): string
    {
        return $this->matrizId;
    }
}
