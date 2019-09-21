<?php

namespace AppBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Exception;

class JWTAuthenticationSuccessListener
{
    private $_jwtTokenType;
    private $_jwtCookieName;
    private $_cookieSecure = FALSE;

    public function __construct($jwtTokenType, $jwtCookieName)
    {
        $this->_jwtTokenType = $jwtTokenType;
        $this->_jwtCookieName = $jwtCookieName;
    }

    /**
     * Add public data to the authentication response
     *
     * @param AuthenticationSuccessEvent $event
     * @return Response|void
     * @throws Exception
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $token = $data['token'];
        $tokenParts = explode(".", $token);
        $tokenPayload = json_decode(base64_decode($tokenParts[1]), TRUE);

        $expirationToken = $tokenPayload['exp'];

        $data['expired_at'] = $expirationToken;

        $data['user'] = array(
            'id' => $user->getId(),
            'name' => $user->getName(),
            'surname' => $user->getSurname(),
            'email' => $user->getUsername(),
            'roles'    => $user->getRoles()
        );

        $event->setData($data);

        $response = $event->getResponse();

        $response->headers->setCookie(
            new Cookie(
                $this->_jwtCookieName,
                $this->_jwtTokenType . ' ' . $token,
                $expirationToken,
                '/',
                NULL,
                $this->_cookieSecure
            )
        );

        return $response;
    }
}