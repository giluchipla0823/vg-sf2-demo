<?php

namespace AppBundle\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

Trait ApiResponser{

    /**
     * Crear una respuesta de éxito
     *
     * @param null $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse($data = NULL, $message = 'OK', $code = Response::HTTP_OK){
        $response = array(
            'code' => $code,
            'message' => $message
        );

        if(!is_null($data)){
            $response['data'] = $data;
        }

        return new JsonResponse($response, $code);
    }

    /**
     * Crea una respuesta de error
     *
     * @param string $message
     * @param int $code
     * @param array $extras
     * @return JsonResponse
     */
    public function errorResponse($message, $code, $extras = array()){
        $response = array('code' => $code, 'message' => $message);

        foreach ($extras as $key => $extra){
            $response[$key] = $extra;
        }

        return new JsonResponse($response, $code);
    }

    /**
     * Crea una respuesta personalizada para mostrar un mensaje
     *
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function showMessageResponse($message, $code = Response::HTTP_OK){
        return $this->successResponse(NULL, $message, $code);
    }
}


