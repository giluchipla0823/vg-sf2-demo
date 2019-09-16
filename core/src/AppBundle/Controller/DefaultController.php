<?php

namespace AppBundle\Controller;

use AppBundle\Traits\ApiResponser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    use ApiResponser;

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * Iniciar sessión
     *
     * @Route("/api/login")
     * @Method({"POST"})
     * @param Request $request
     */
    public function loginAction(Request $request)
    {

    }

    /**
     * Cerrar sessión
     *
     * @Route("/api/logout")
     * @Method({"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function logoutAction(Request $request)
    {
        $response = $this->showMessageResponse('Logout action');
        $response->headers->clearCookie('jwt');

        return $response;
    }

    /**
     * Mostrar pagina
     *
     * @Route("/api/page")
     * @Method({"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function pageAction(Request $request){

        throw new \Exception('asacsccaca', 404);

        return $this->showMessageResponse('page action');
    }


}
