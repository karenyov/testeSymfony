<?php

namespace App\Core\EventListener;

use App\Core\Security\AccessLog;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\RequestStack;


class JWTAuthenticationListener
{
    public function __construct(
        private RequestStack $requestStack,
        private readonly AccessLog $accessLog
    ) {
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $this->accessLog->create($request);
    }
}
