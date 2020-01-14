<?php

namespace AppBundle\Repository;

use AppBundle\Exceptions\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;

class BaseRepository extends EntityRepository
{
    protected $timestampDeletedAt = TRUE;

    /**
     * Persistir datos un recurso
     *
     * @param $model
     * @throws OptimisticLockException
     */
    protected function persistDatabase($model){
        $em = $this->getEntityManager();
        $em->persist($model);

        return $em->flush();
    }

    /**
     * Obtener los datos de un recurso por su id
     *
     * @param int $id
     * @param bool $deletedAt
     * @return object|null
     * @throws EntityNotFoundException
     */
    public function findOrFail($id, $deletedAt = TRUE){
        $filter = array('id' => $id);

        if($deletedAt && $this->timestampDeletedAt){
            $filter['deletedAt'] = NULL;
        }

        if(!$model = $this->findOneBy($filter)){
            throw new EntityNotFoundException($this->getClassName());
        }

        return $model;
    }

    /**
     * Restaurar un recurso eliminado de forma lógica
     *
     * @param int $id
     * @throws \Exception
     */
    public function restore($id){
        $model = $this->findOrFail($id, FALSE);
        $model->setDeletedAt(NULL);

        return $this->persistDatabase($model);
    }

    /**
     * Eliminar de forma lógica un recurso
     *
     * @param int $id
     * @throws \Exception
     */
    public function remove($id){
        $model = $this->findOrFail($id);
        $model->setDeletedAt(new \DateTime('now'));

        return $this->persistDatabase($model);
    }

}