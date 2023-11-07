<?php

namespace App\Core\EventListener;

use App\Core\Security\AccessLog;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class AccessLogListener
{
    public function __construct(
        private readonly AccessLog $accessLog
    ) {
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $this->accessLog->create($request);
    }
}
