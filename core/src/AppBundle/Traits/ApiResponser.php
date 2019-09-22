<?php

namespace AppBundle\Traits;

use AppBundle\Helpers\AppHelper;
use AppBundle\Helpers\JsonResponseHelper;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

Trait ApiResponser{

    /**
     * Crear una respuesta de éxito
     *
     * @param null|array $data
     * @param string $message
     * @param int $code
     * @param array $extras
     * @return JsonResponse
     */
    protected function successResponse($data, $message = 'OK', $code = Response::HTTP_OK, $extras = array()){
        return $this->_buildResponse($data, $message, $code, $extras);
    }

    /**
     * Crear respuesta para colecciones de una instancia
     *
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    protected function showCollectionResponse($data, $code = Response::HTTP_OK){
        $data = $this->serializerCollection($data);

        return $this->successResponse($data);
    }

    /**
     * Crear respuesta para una instancia
     *
     * @param object $data
     * @param int $code
     * @return JsonResponse
     */
    protected function showInstanceResponse($data, $code = Response::HTTP_OK){
        $data = $this->serializerInstance($data);

        return $this->successResponse($data);
    }

    /**
     * Serializar los datos de una instancia
     *
     * @param object $instance
     * @return mixed|null
     */
    protected function serializerInstance($instance){
        if(is_null($instance)){
            return NULL;
        }

        return $this->applySerializer($instance, $instance->relations);
    }

    /**
     * Serializar datos de una colección
     *
     * @param array $collection
     * @return array|mixed
     */
    protected function serializerCollection($collection){
        if(count($collection) === 0){
            return array();
        }

        $relations = current($collection)->relations;

        return $this->applySerializer($collection, $relations);
    }

    /**
     * Proceso de serialización de datos
     *
     * @param array|object $data
     * @param array $relations
     * @return mixed
     */
    protected function applySerializer($data, $relations){
        $container = AppHelper::getContainerBuilder();

        if ($container->has('jms_serializer')) {

            $includes = AppHelper::getIncludesToSerializer($relations);
            $context = SerializationContext::create()->setGroups($includes);
            $context->setSerializeNull(true);

            $serializer = $container->get('jms_serializer');

            $data = json_decode($serializer->serialize($data, 'json', $context), TRUE);
        }

        return $data;
    }

    /**
     * Crea una respuesta de error
     *
     * @param string $message
     * @param int $code
     * @param array $extras
     * @return JsonResponse
     */
    protected function errorResponse($message, $code, $extras = array()){
        return $this->_buildResponse(NULL, $message, $code, $extras);
    }

    /**
     * Crea una respuesta personalizada para mostrar un mensaje
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function showMessageResponse($message, $code = Response::HTTP_OK){
        return $this->successResponse(NULL, $message, $code);
    }

    /**
     * Construye la estructura de respuestas en formato json
     *
     * @param null|array $data
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


