<?php

namespace BviEmailBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EmailRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EmailRepository extends EntityRepository
{
    public function getList($params = array()) {
        
        $query      = $this->createQueryBuilder('em');
        $refineQtr  = $this->prepareFilters($query,$params);
        
        return $refineQtr;
        
    }
    
    //prepare filter operation
    
    public function prepareFilters($query,$params) {
        
        $sortOrd= 'desc'; $sortBy = 'em.id';
        
        if(isset($params['subject']) && $params['subject']!='') {
            $query->where( $query->expr()->like('em.subject', ':SUBJECT'));
            $query->setParameter('SUBJECT','%'.$params['subject'].'%');
        }
        if(isset($params['status']) && $params['status']!='') {
            $query->andWhere('em.status=:STATUS');
            $query->setParameter('STATUS',$params['status']);
        }
        if(isset($params['sortBy']) && $params['sortBy']!='') {
            $sortBy = 'em.'.$params['sortBy'];
        }
        if(isset($params['sortOrd']) && $params['sortOrd']!='') {
            $sortOrd = $params['sortOrd'];
        }
        
        $query->orderBy($sortBy, $sortOrd);
       # echo $query->getQuery()->getSql();die;
        return $query;
    }
}
