<?php

namespace AppBundle\EventListener;

use AppBundle\Traits\ApiResponser;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events as JWTEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class JWTNotFoundListener
{
    use ApiResponser;

    /**
     * @var RequestStack $_requestStack
     */
    private $_requestStack;

    /**
     * Disparador de eventos
     *
     * @var EventDispatcherInterface $_dispatcher
     */
    private $_dispatcher;

    /**
     * Nombre de la cookie que almacena el refresh token
     *
     * @var string $_jwtRefreshCookieName
     */
    private $_jwtRefreshCookieName;

    public function __construct(RequestStack $requestStack, EventDispatcherInterface $dispatcher, $jwtRefreshCookieName)
    {
        $this->_requestStack = $requestStack;
        $this->_dispatcher = $dispatcher;
        $this->_jwtRefreshCookieName = $jwtRefreshCookieName;
    }

    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        if($this->_requestStack->getCurrentRequest()->cookies->get($this->_jwtRefreshCookieName)){
            $expiredEvent = new JWTExpiredEvent($event->getException(), $event->getResponse());

            $this->_dispatcher->dispatch(JWTEvents::JWT_EXPIRED, $expiredEvent);

            return FALSE;
        }

        $response = $this->errorResponse(
            Response::HTTP_FORBIDDEN . ' Forbidden: Missing token authentication',
            Response::HTTP_FORBIDDEN
        );

        return $event->setResponse($response);
    }
}