<?php

namespace App\Core\Security;

use App\Core\Repository\UsuarioLogAccessRepository;
use App\Core\Security\ApiKeyUser;
use App\Core\Enum\HttpMethod;
use App\Core\Entity\UsuarioLogAccess;

use Symfony\Component\HttpFoundation\Request;

class AccessLog
{
    public function __construct(
        private readonly ApiKeyUser $apiKeyUser,
        private readonly UsuarioLogAccessRepository $usuarioLogAccessRepository,
    ) {
    }

    public function create(Request $request): void
    {
        $methodString = $request->getMethod();
        $method = HttpMethod::fromString($methodString);
        $date = new \DateTimeImmutable();
        $ip = $request->getClientIp();
        $url = $request->getUri();
        $userAgent = $request->headers->get('User-Agent');
        $params = $request->getContent();

        $usuarioAcesso = new UsuarioLogAccess();
        $usuarioAcesso->setMethod($method);
        $usuarioAcesso->setData($date);
        $usuarioAcesso->setParams($params);
        $usuarioAcesso->setUrl($url);
        $usuarioAcesso->setIp($ip);
        $usuarioAcesso->setUserAgent($userAgent);

        $usuario = $this->apiKeyUser->getUserFromToken();
        if ($usuario) {
            $usuarioAcesso->setUsuario($usuario);
        }

        $this->usuarioLogAccessRepository->save($usuarioAcesso);
    }
}
