<?php

namespace App\Supply\Request\Pedido;

use App\Core\Request\AbstractJsonRequest;
use Symfony\Component\Validator\Constraints as Assert;
use App\Supply\Validator\Constraints\Pedido\PedidoUnique;

#[PedidoUnique]
class PedidoCreateRequest extends AbstractJsonRequest
{
    #[Assert\NotBlank]
    #[Assert\GreaterThan(0)]
    public readonly int $numPedido;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(2022)]
    public readonly int $anoPedido;

    #[Assert\NotBlank]
    public readonly string $empresaId;

    public function getNumPedido(): int
    {
        return $this->numPedido;
    }

    public function getAnoPedido(): int
    {
        return $this->anoPedido;
    }

    public function getEmpresaId(): string
    {
        return $this->empresaId;
    }
}
