<?php

namespace App\Core\Security\Authenticator;

use App\Core\Repository\UsuarioRepository;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class ApiKeyAuthenticator extends AbstractAuthenticator
{

    public function __construct(
        private readonly UsuarioRepository $usuarioRepository,
        private readonly JWTTokenManagerInterface $jwtTokenManager,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        $data = json_decode($request->getContent(), true);
        return isset($data['email']) && isset($data['senha']);

        return $request->attributes->get('_route') === 'custom_login' && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? null;
        $senha = $data['senha'] ?? null;

        $usuario = $this->usuarioRepository->findByEmail($email);

        if ($usuario === null || !password_verify($senha, $usuario->getPassword())) {
            throw new AuthenticationException('Invalid credentials');
        }
        return new Passport(new UserBadge($usuario->getUserIdentifier()), new PasswordCredentials($senha));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $user = $token->getUser();
        $token = $this->jwtTokenManager->create($user);


        $refreshToken = "";

        return new JsonResponse(['token' => $token, 'refresh_token' => $refreshToken]);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return null;
    }
}
