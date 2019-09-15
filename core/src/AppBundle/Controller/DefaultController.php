<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
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
     * @Route("/api/login_check")
     * @Method({"POST"})
     */
    public function loginCheckAction(Request $request)
    {
        
    }

    /**
     * @Route("/api/logout")
     * @Method({"GET"})
     */
    public function logoutAction(Request $request)
    {
        $response = new JsonResponse(array('code' => Response::HTTP_OK, 'message' => 'logout action'), Response::HTTP_OK);
        $response->headers->clearCookie("jwt");

        return $response;
    }

    /**
     * @Route("/api/page")
     * @Method({"GET"})
     */
    public function pageAction(Request $request){
        return new JsonResponse(array('code' => Response::HTTP_OK, 'message' => 'page action'), Response::HTTP_OK);
    }


}
