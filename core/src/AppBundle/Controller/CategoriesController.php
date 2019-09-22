<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Traits\ApiResponser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends Controller
{
    use ApiResponser;

    /**
     * Lista de categorías
     *
     * @Route("/api/categories")
     * @Method({"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        $queryParams = $request->query->all();

        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAllWithFilters($queryParams);

        return $this->showCollectionResponse($categories);
    }

    /**
     * Obtener categoría por su id
     *
     * @Route("/api/categories/{id}")
     * @Method({"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function showAction(Request $request, $id){
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->findOrFail($id);

        return $this->showInstanceResponse($category);
    }

    /**
     * Registrar categporías
     *
     * @Route("/api/categories")
     * @Method({"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function storeAction(Request $request){
        $repository = $this->getDoctrine()->getRepository(Category::class);

        $repository->create($request->request->all());

        return $this->showMessageResponse('Category created successfully', Response::HTTP_CREATED);
    }
}
