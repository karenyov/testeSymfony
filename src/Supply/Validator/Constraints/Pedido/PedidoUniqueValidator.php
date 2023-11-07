<?php

namespace App\Supply\Validator\Constraints\Pedido;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Supply\Repository\PedidoRepository;

class PedidoUniqueValidator extends ConstraintValidator
{

    public function __construct(private readonly PedidoRepository $repository)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!isset($value->numPedido) || !isset($value->anoPedido)) {
            return;
        }

        if (!$this->repository->isUnique(
            $value->getNumPedido(),
            $value->getAnoPedido(),
            $value->getId()
        )) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
