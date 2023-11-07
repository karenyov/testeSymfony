<?php

namespace App\Core\EventListener;

use App\Core\Entity\Usuario;

use DateTime;
use DateTimeZone;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

use Symfony\Component\Security\Core\User\UserInterface;

class JWTCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload  = $event->getData();
        $user = $event->getUser();

        $this->setExpiration($payload);
        $this->setUser($payload, $user);

        $event->setData($payload);
    }

    private function setExpiration(array &$payload): void
    {
        $payload['iat'] = (new DateTime('now', new DateTimeZone('UTC')))->getTimestamp();
        $payload['exp'] = (new DateTime('+1 day', new DateTimeZone('UTC')))->getTimestamp();
    }

    private function setUser(array &$payload, UserInterface $user): void
    {
        if ($user instanceof Usuario) {
            $payload['id'] = $user->getId();
            $payload['name'] = $user->getNome();
        }
    }
}
