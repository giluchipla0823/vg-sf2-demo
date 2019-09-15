<?php


namespace AppBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Symfony\Component\HttpFoundation\Response;

class JWTExpiredListener
{
    /**
     * @param JWTExpiredEvent $event
     */
    public function onJWTExpired(JWTExpiredEvent $event)
    {
        $response = $event->getResponse();

        $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
        $response->setMessage('Your token is expired.');
    }
}