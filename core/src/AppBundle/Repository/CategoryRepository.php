<?php

namespace AppBundle\Repository;

class CategoryRepository extends BaseRepository
{
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