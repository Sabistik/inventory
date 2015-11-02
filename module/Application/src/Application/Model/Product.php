<?php

namespace Application\Model;

class Product {
    
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
    
    public function getList($sQuery = null)
    {
        $aWhere = array();
        
        if(!empty($sQuery) && strpos($sQuery, ':') !== false) {
            list($sFieldName, $sValue) = explode(':', $sQuery);
            $aWhere[$sFieldName] = $sValue;
        }
        
        $oProducts = $this->getEntityManager()->getRepository('Application\Entity\Product')->findBy($aWhere);

        $aReturn = array();
        foreach($oProducts as $oProductItem) {
            
            $oItems = $oProductItem->getItems();
            if($oItems->count()) {
                $aReturn[] = $oProductItem;
            }
            
        }
        
        return $aReturn;
    }
    
    public function getByBarcodeNumber($iBarcode)
    {
        $oProduct = $this->getEntityManager()->getRepository('Application\Entity\Product')->findOneByBarcodeNumber($iBarcode);
        
        #andrzelika trumbowicz
        #barbarum atus
        
        if($oProduct) {
            return $oProduct;
        }
        
        return null;
    }
    
    public function update($id, $aData)
    {
        $oProduct = $this->getEntityManager()->getRepository('Application\Entity\Product')->findOneByBarcodeNumber($id);
        
        if(!$oProduct) {
            return array('status' => false, 'message' => 'Product not found!');
        }
        
        if(isset($aData['tags']) && is_array($aData['tags'])) {
            
            $oProduct->getTags()->clear();
            
            foreach($aData['tags'] as $aTag) {
                if($aTag['checked']) {
                    $oTag = $this->getEntityManager()->getRepository('Application\Entity\Tag')->find($aTag['id']);
                    $oProduct->addTag($oTag);
                }
            }
            
            $this->getEntityManager()->persist($oProduct);
            $this->getEntityManager()->flush();
        }
        
       
        return array('status' => true);
        
    }
}

