<?php

namespace Application\Model;

use Application\Entity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;


class Item {
    
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
    
    public function get($id)
    {
        $oItemsRows = $this->getEntityManager()->getRepository('Application\Entity\Item')->find($id);
        
        return $oItemsRows;
    }
    
    public function getList($iLimit = null, $sOrder = null)
    {
        $aOrder = array();
        
        if(!empty($sOrder) && strpos($sOrder, ':') !== false) {
            list($sFieldName, $sDirestion) = explode(':', $sOrder);
            $aOrder[$sFieldName] = $sDirestion;
        }
        
        $oItemsRows = $this->getEntityManager()->getRepository('Application\Entity\Item')->findBy(array(), $aOrder, $iLimit);
        
        return $oItemsRows;
    }
    
    public function create($aData)
    {
        $oItem = new Entity\Item();
        $oItem->setExpirationDate(new \DateTime($aData['date']));
        
        $oProduct = $this->getEntityManager()->getRepository('Application\Entity\Product')->findOneByBarcodeNumber($aData['barcodeNumber']);
        if(!$oProduct) {
            $oProduct = new Entity\Product();
            $oProduct->setBarcodeNumber($aData['barcodeNumber']);
            if(isset($aData['name']) && $aData['name']) {
                $oProduct->setName($aData['name']);
            }
            $this->getEntityManager()->persist($oProduct);
        }
        
        $oItem->setProduct($oProduct);
        
        $this->getEntityManager()->persist($oItem);
        $this->getEntityManager()->flush();
        
        return $oItem;
    }
    
    
    /*
     * szuka najpierw po barcode number potem po id itemu
     */
    public function delete($id)
    {
        $oProduct = $this->getEntityManager()->getRepository('Application\Entity\Product')->findOneByBarcodeNumber($id);
        
        if($oProduct) {
            $oItems = $oProduct->getItems();
            if($oItems->count() == 1) {
                
                $oItem = $oItems->current();
                $this->getEntityManager()->remove($oItem);
                $this->getEntityManager()->flush();
                
                return array('status' => true);
            } elseif($oItems->count() > 1) {
                
                return $oItems;
                
            }
            
        } else {
            $oItem = $this->getEntityManager()->getRepository('Application\Entity\Item')->find($id);
            if($oItem) {
                $this->getEntityManager()->remove($oItem);
                $this->getEntityManager()->flush();
                
                return array('status' => true);
            }
            
            return array('status' => false);
            
        }
        
        return array('status' => false);
    }
    
    public function update($id, $aData)
    {
        $oItem = $this->getEntityManager()->getRepository('Application\Entity\Item')->find($id);
        
        $oHydrator = new DoctrineHydrator($this->getEntityManager());
        $oItem = $oHydrator->hydrate($aData, $oItem);
        
        /*if(isset($aData['opened'])) {
            $oItem->setOpened($aData['opened']);
        }
        if(isset($aData['note'])) {
            $oItem->setNote($aData['note']);
        }
        if(isset($aData['expiration_date'])) {
            $oItem->setExpirationDate(new \DateTime($aData['expiration_date']));
        }*/
        
        $this->getEntityManager()->persist($oItem);
        $this->getEntityManager()->flush();
        
        return $oItem;
    }
}

