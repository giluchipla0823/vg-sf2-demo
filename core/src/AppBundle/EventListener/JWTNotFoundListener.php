<?php

namespace AppBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JWTNotFoundListener
{

    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $data = array(
            'code' => Response::HTTP_FORBIDDEN,
            'message' => Response::HTTP_FORBIDDEN . ' Forbidden: Missing token authentication'
        );

        $response = new JsonResponse($data, Response::HTTP_FORBIDDEN);

        return $event->setResponse($response);
    }
}