<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Category;

class CategoryRepository extends BaseRepository
{
    /**
     * Crear categoría
     *
     * @param array $data
     * @throws \Exception
     */
    public function create(array $data){
        $category = new Category();

        $description = isset($data['description']) ? $data['description'] : NULL;

        $category->setName($data['name']);
        $category->setDescription($description);
        $category->setCreatedAt(new \DateTime('now'));

        return $this->persistDatabase($category);
    }

    public function findAllWithFilters($data){
        $query = $this->createQueryBuilder('c');
        $query = $this->_getQueryConditionsByFilters($query, $data);
        $query = $query->getQuery();

        return $query->getResult();
    }

    private function _getQueryConditionsByFilters($query, $data){
        $columns = $this->getClassMetadata()->getFieldNames();

        foreach ($data as $key => $value){
            if(in_array($key, $columns)){
                $query = $query->andWhere('c.' . $key . ' LIKE :' . $key)
                    ->setParameter($key, '%'. $value .'%');
            }
        }

        return $query;
    }
}