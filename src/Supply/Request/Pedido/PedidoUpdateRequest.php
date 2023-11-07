<?php

namespace App\Supply\Request\Pedido;

use App\Core\Request\AbstractJsonRequest;
use App\Supply\Validator\Constraints\Pedido\PedidoUnique;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\HttpFoundation\Request;

#[PedidoUnique]
class PedidoUpdateRequest extends AbstractJsonRequest
{
    #[Assert\NotBlank]
    #[Assert\GreaterThan(0)]
    public readonly int $numPedido;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(2022)]
    public readonly int $anoPedido;

    #[Assert\NotBlank]
    public readonly int $empresaId;

    public function getNumPedido(): int
    {
        return $this->numPedido;
    }

    public function getAnoPedido(): int
    {
        return $this->anoPedido;
    }

    public function getEmpresaId(): int
    {
        return $this->empresaId;
    }
}
