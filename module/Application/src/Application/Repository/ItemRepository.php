<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class ItemRepository extends EntityRepository
{
    public function findByTraits($sQuery = null, $sOrder = null, $iLimit = null)
    {
        $qb = $this->createQueryBuilder('i');
        
        $this->query($qb, $sQuery);
        $this->order($qb, $sOrder);
        $this->limit($qb, $iLimit);
        
        //echo $qb->getDql(); exit();
        
        $query = $qb->getQuery();
        
        $result = $query->getResult();
        
        return $result;
    }
    
    private function limit($qb, $iLimit)
    {
        if($iLimit) {
            $qb->setMaxResults($iLimit);
        }
    }
    
    private function order($qb, $sOrder)
    {
        if(!empty($sOrder) && strpos($sOrder, ':') !== false) {
            list($sFieldName, $sDirection) = explode(':', $sOrder);
            
            $this->checkFieldName($sFieldName);
            
            $qb->orderBy('i.'.$sFieldName, $sDirection);
        }
        
    }
    
    private function query($qb, $sQuery)
    {
        // eq, like, lt, lte(less than), gt, gte(greater than)
            
        $aSegments = explode(',', $sQuery);
        $iParam = 1;
        foreach($aSegments as $sSegment) {
            if(substr_count($sSegment, ':') == 2) {
                list($sFieldName, $sExpr, $sValue) = explode(':', $sSegment);

                $this->checkFieldName($sFieldName);

                $qb->andWhere($qb->expr()->$sExpr('i.'.$sFieldName, '?'.$iParam));
                $qb->setParameter($iParam, $sValue);
                $iParam++;
            }
        }
        
    }
    
    private function checkFieldName($sFieldName)
    {
        $aFieldNames = $this->getClassMetadata()->getFieldNames();
        
        if(array_search($sFieldName, $aFieldNames) === false) {
            throw new \Exception('Traits query error. Field name not in entity.');
        }
    }
}
