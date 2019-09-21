<?php

namespace AppBundle\Traits;

use AppBundle\Helpers\JsonResponseHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

Trait ApiResponser{

    /**
     * Crear una respuesta de éxito
     *
     * @param $data
     * @param string $message
     * @param int $code
     * @param array $extras
     * @return JsonResponse
     */
    public function successResponse($data, $message = 'OK', $code = Response::HTTP_OK, $extras = array()){
        return $this->_buildResponse($data, $message, $code, $extras);
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
        return $this->_buildResponse(NULL, $message, $code, $extras);
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

    /**
     * Construye la estructura de respuestas en formato json
     *
     * @param $data
     * @param string $message
     * @param int $code
     * @param array $extras
     * @return JsonResponse
     */
    private function _buildResponse($data, $message, $code, $extras = array()){
        $response = JsonResponseHelper::getResponse($data, $message, $code, $extras);

        return new JsonResponse($response, $code);
    }
}


