<?php

namespace AppBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Lexik\Bundle\JWTAuthenticationBundle\Events as JWTEvents;

class RefreshedTokenListener implements EventSubscriberInterface
{
    /**
     * Tiempo de vida del refresh token
     *
     * @var string $_ttl
     */
    private $_ttl;

    /**
     * Nombre de la cookie que almacena el valor del refresh token
     *
     * @var string $_cookieName
     */
    private $_cookieName;

    /**
     * Valor para especificar si la cookie es segura
     *
     * @var bool $_cookieSecure
     */
    private $_cookieSecure = FALSE;

    public function __construct($ttl, $cookieName)
    {
        $this->_ttl = $ttl;
        $this->_cookieName = $cookieName;
    }

    public function setRefreshToken(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $refreshToken = $data['refresh_token'];
        $response = $event->getResponse();

        if ($refreshToken) {
            $expiration = new \DateTime();
            $expiration = $expiration->getTimestamp() + $this->_ttl;

            $response->headers->setCookie(
                new Cookie(
                    $this->_cookieName,
                    $refreshToken,
                    $expiration,
                    '/',
                    NULL,
                    $this->_cookieSecure
                )
            );
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            JWTEvents::AUTHENTICATION_SUCCESS => array(
                array('setRefreshToken')
            )
        );
    }
}