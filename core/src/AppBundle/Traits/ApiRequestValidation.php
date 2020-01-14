<?php

namespace AppBundle\Traits;

use AppBundle\Exceptions\ValidationException;
use AppBundle\Helpers\AppHelper;
use AppBundle\Helpers\ArrayHelper;
use Symfony\Component\Validator\Constraints as Assert;

Trait ApiRequestValidation{

    /**
     * Validar datos de las peticiones
     *
     * @param array $data
     * @param array $constraints
     * @throws ValidationException
     */
    public function validateDataRequest(array $data, array $constraints){
        $container = AppHelper::getContainerBuilder();
        $validator = $container->get('validator');

        $data = ArrayHelper::onlyItems($data, array_keys($constraints));

        $errors = $validator->validate($data, new Assert\Collection($constraints));

        if(count($errors) > 0){
            throw new ValidationException($errors);
        }
    }
}