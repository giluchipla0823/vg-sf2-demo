<?php


namespace AppBundle\Exceptions;

use AppBundle\Traits\ApiRequestValidation;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ValidationException extends Exception
{
    use ApiRequestValidation;

    /**
     * Lista de errores
     *
     * @var array $errors
     */
    protected $errors;

    public function __construct($errors, $code = Response::HTTP_BAD_REQUEST, $message = "Validation failed", Throwable $previous = null)
    {
        $this->setErrors($errors);

        parent::__construct($message, $code, $previous);
    }

    /**
     * Obtener errores de validación
     *
     * @return array
     */
    public function getErrors(){
        return $this->errors;
    }

    /**
     * Asignar y aplicar formato a errores de validación
     *
     * @param ConstraintViolationListInterface $errors
     */
    public function setErrors(ConstraintViolationListInterface $errors) {
        $this->errors = $this->transformValidatorErrors($errors);
    }
}