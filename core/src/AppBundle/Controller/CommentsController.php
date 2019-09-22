<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Traits\ApiResponser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CommentsController extends Controller
{
    use ApiResponser;

    /**
     * Lista de comentarios
     *
     * @Route("/api/comments", name="comments")
     * @Method({"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Comment::class);
        $comments = $repository->findAll();

        return $this->showAll($comments);
    }
}
