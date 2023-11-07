<?php

namespace App\Core\Validator\Constraints\Usuario;

use App\Core\Repository\UsuarioRepository;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UsuarioUniqueValidator extends ConstraintValidator
{

    public function __construct(private readonly UsuarioRepository $repository)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!isset($value->email)) {
            return;
        }

        if (!$this->repository->isUnique(
            $value->getEmail(),
            $value->getId()
        )) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
