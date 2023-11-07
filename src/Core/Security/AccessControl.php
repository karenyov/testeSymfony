<?php

namespace App\Core\Security;

use App\Core\Repository\UsuarioRepository;

use Ramsey\Uuid\UuidInterface;

class AccessControl
{
    public function __construct(
        private readonly UsuarioRepository $usuarioRepository
    ) {
    }

    public function hasAccessToUrl(UuidInterface $id, string $url, string $method): bool
    {
        return $this->usuarioRepository->hasAccessToUrl(
            $id,
            $url,
            $method
        );
    }
}
