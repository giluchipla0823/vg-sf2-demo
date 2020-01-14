<?php


namespace AppBundle\Controller;

use AppBundle\Helpers\AppHelper;
use AppBundle\Traits\ApiRequestValidation;
use AppBundle\Traits\ApiResponser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiController extends Controller
{
    use ApiResponser, ApiRequestValidation;

    protected $entityManager;
    protected $repository;

    public function __construct($entityClass)
    {
        $container = AppHelper::getContainerBuilder();

        $doctrine = $container->get('doctrine');
        $this->entityManager = $doctrine->getEntityManager();
        $this->repository = $this->entityManager->getRepository($entityClass);
    }
}