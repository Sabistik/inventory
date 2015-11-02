<?php

namespace Application\Model;

use Application\Entity;

class Tag {
    
    private $oEntityManager;

    public function __construct()
    {
        
    }
    
    public function setEntityManager($oEntityManager)
    {
        $this->oEntityManager = $oEntityManager;
    }


    public function getEntityManager()
    {
        return $this->oEntityManager;
    }
    
    public function getList($sQuery)
    {
        $aWhere = array();
        
        if(!empty($sQuery) && strpos($sQuery, ':') !== false) {
            list($sFieldName, $sValue) = explode(':', $sQuery);
            $aWhere[$sFieldName] = $sValue;
        }
        
        if(count($aWhere)) {
            $query = $this->getEntityManager()->getRepository('Application\Entity\Tag')->createQueryBuilder('t');
            
            foreach($aWhere as $sName => $sValue) {
                $query->where('t.'.$sName.' LIKE :'.$sName)
                ->setParameter($sName, '%'.$sValue.'%');
            }
                    
            $q = $query->getQuery();
                    
            return $q->getResult();
        } else {
            return $this->getEntityManager()->getRepository('Application\Entity\Tag')->findBy(array(), array('name' => 'ASC'));
        }
        
    }
    
    public function create($aData)
    {
        $aTag = new Entity\Tag();
        
        $aData['name'] = trim($aData['name']);
        
        $aTag->setName($aData['name']);
        
        $this->getEntityManager()->persist($aTag);
        $this->getEntityManager()->flush();
        
        return $aTag;
    }
    
    
}

