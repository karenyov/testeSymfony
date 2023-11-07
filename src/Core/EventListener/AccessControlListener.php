<?php

namespace App\Core\EventListener;

use App\Core\Security\ApiKeyUser;
use App\Core\Security\AccessControl;

use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessControlListener
{
    public function __construct(
        private readonly ApiKeyUser $apiKeyUser,
        private readonly AccessControl $accessControl
    ) {
    }

    public function onKernelController(ControllerEvent $event)
    {
        $request = $event->getRequest();
        $method = $request->getMethod();
        $url = explode("_", $request->get('_route'))[0];

        $usuario = $this->apiKeyUser->getUserFromToken();

        $resultado = $this->accessControl->hasAccessToUrl($usuario->getId(), $url, $method);

        if (!$resultado) {
            throw new AccessDeniedException("Você não tem acesso a esta URL.");
        }
    }
}
