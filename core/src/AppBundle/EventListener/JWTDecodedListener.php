<?php


namespace AppBundle\EventListener;


use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\ExpiredTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTDecodedListener
{
    private $_jwtCookieName;
    private $_requestStack;
    private $_jwtTokenAuthenticator;

    public function __construct(
        RequestStack $requestStack,
        $jwtCookieName,
        $jwtTokenAuthenticator
    )
    {
        $this->_requestStack = $requestStack;
        $this->_jwtCookieName = $jwtCookieName;
        $this->_jwtTokenAuthenticator = $jwtTokenAuthenticator;
    }

    /**
     *
     * @param JWTDecodedEvent $event
     * @return void
     * @throws \Exception
     */
    public function onJWTDecoded(JWTDecodedEvent $event)
    {
        if (!($request = $this->_requestStack->getCurrentRequest())) {
            return;
        }

        $payload = $event->getPayload();

        if (!isset($payload['ip']) ||
            ($payload['ip'] !== $request->getClientIp()) ||
            !$this->_validateCookieJWT($request)) {
            $event->markAsInvalid();
        }

        $currentDate = new \DateTime();

        if($currentDate->getTimestamp() > $payload['exp']){
            throw new ExpiredTokenException();
        }
    }

    private function _validateCookieJWT($request){
        $tokenAuthorization = $request->headers->get('Authorization');
        $cookieJWT = $request->cookies->get($this->_jwtCookieName);

        if($cookieJWT !== $tokenAuthorization){
            return FALSE;
        }

        return TRUE;
    }
}