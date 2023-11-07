<?php

namespace App\Core\Security;

use App\Core\Entity\Usuario;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\RuntimeException;

class ApiKeyUser
{
    public function __construct(private readonly TokenStorageInterface $tokenStorage, private readonly  JWTTokenManagerInterface $jwtManager)
    {
    }

    public function getUserFromToken(): ?Usuario
    {
        $token = $this->tokenStorage->getToken();

        if ($token === null) {
            return null;
            // throw new RuntimeException('No authentication token found.');
        }

        $user = $token->getUser();

        if (!$user instanceof Usuario) {
            throw new RuntimeException('Invalid user object in the authentication token.');
        }

        return $user;
    }
}
