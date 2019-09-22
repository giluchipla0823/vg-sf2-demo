<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Traits\ApiResponser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CategoriesController extends Controller
{
    use ApiResponser;

    /**
     * Lista de categorías
     *
     * @Route("/api/categories", name="categories")
     * @Method({"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        $queryParams = $request->query->all();

        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAllWithFilters($queryParams);

        return $this->showAll($categories);
    }
}
