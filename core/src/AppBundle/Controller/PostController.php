<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Traits\ApiResponser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    use ApiResponser;

    /**
     * Lista de publicaciones
     *
     * @Route("/api/posts")
     * @Method({"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $posts = $repository->findAll();

        return $this->showCollectionResponse($posts);
    }

    /**
     * Obtener publicación por su id
     *
     * @Route("/api/posts/{id}")
     * @Method({"GET"})
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function showAction(Request $request,  $id){
        $repository = $this->getDoctrine()->getRepository(Post::class);

        $post = $repository->findOrFail($id);

        return $this->showInstanceResponse($post);
    }
}
