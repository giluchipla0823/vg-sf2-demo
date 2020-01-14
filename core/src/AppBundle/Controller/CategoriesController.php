<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Exceptions\ValidationException;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

class CategoriesController extends ApiController
{

    public function __construct()
    {
        parent::__construct(Category::class);
    }

    /**
     * Lista de categorías
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        $categories = $this->repository->findAll();

        return $this->showCollectionResponse($categories);
    }

    /**
     * Obtener categoría por su id
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function showAction(Request $request, $id){
        $category = $this->repository->findOrFail($id);

        return $this->showInstanceResponse($category);
    }

    /**
     * Registro de categoría
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function storeAction(Request $request){

        $constraints = array(
            'name' => array(
                new Assert\NotBlank(),
                new \AppBundle\Validator\Constraints\UniqueEntity(array(
                    'fields' => array('name'),
                    'entityClass' => Category::class
                ))
            )
        );

        $requestParams = $request->request->all();

        $this->validateDataRequest($requestParams, $constraints);

        $this->repository->create($requestParams);

        return $this->showMessageResponse('Category created successfully', Response::HTTP_CREATED);
    }


}
