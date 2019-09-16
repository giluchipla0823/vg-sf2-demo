<?php

namespace AppBundle\Traits;

use AppBundle\Exceptions\ValidationException;
use AppBundle\Helpers\AppHelper;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;

Trait ApiRequestValidation{

    /**
     * Validar datos de las peticiones
     *
     * @param array $data
     * @param array $constraints
     * @throws ValidationException
     */
    public function validateDataRequest(array $data, $constraints){
        $container = AppHelper::getContainerBuilder();
        $validator = $container->get('validator');

        $errors = $validator->validate($data, new Assert\Collection($constraints));

        if(count($errors) > 0){
            throw new ValidationException($errors);
        }
    }

    /**
     * Aplicar formato a los errores de validación
     *
     * @param ConstraintViolationListInterface $errors
     * @return array
     */
    public function transformValidatorErrors(ConstraintViolationListInterface $errors)
    {
        $response = array();

        foreach ($errors as $error) {
            $key = str_replace(array('[', ']'), '', $error->getPropertyPath());
            $response[] = array(
              'field' => $key,
              'message' => $error->getMessage()
            );
        }

        return $response;
    }
}