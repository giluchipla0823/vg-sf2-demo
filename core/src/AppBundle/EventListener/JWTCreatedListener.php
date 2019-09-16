<?php


namespace AppBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{
    private $_jwtTokenTTL;
    private $_requestStack;


    public function __construct(RequestStack $requestStack, $ttl)
    {
        $this->_requestStack = $requestStack;
        $this->_jwtTokenTTL = $ttl;
    }

    /**
     *
     *
     * @param JWTCreatedEvent $event
     * @throws \Exception
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->_requestStack->getCurrentRequest();
        // $expiration = new \DateTime('+2 hour');
        $expiration = new \DateTime();

        $payload = $event->getData();
        $payload['ip'] = $request->getClientIp();
        $payload['exp'] = $expiration->getTimestamp() + $this->_jwtTokenTTL;

        $event->setData($payload);
    }
}