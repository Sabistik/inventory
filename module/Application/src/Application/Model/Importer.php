<?php

namespace Application\Model;

use Application\Entity;

class Importer {
    
    private $oEntityManager;

    public function __construct()
    {
        
    }
    
    public function setEntityManager($oEntityManager)
    {
        $this->oEntityManager = $oEntityManager;
    }


    private function getEntityManager()
    {
        return $this->oEntityManager;
    }
    
    public function test()
    {
        
        exit();
        $aFile = file('data/inventory.csv');
        
        foreach($aFile as $sLine) {
            $aData = explode(',', $sLine);
            list($sName, $sExpiration, $sOpened, $iBarcode, $sNote, $iPlace, $sTag) = $aData;
            
            $oProduct = $this->getEntityManager()->getRepository('Application\Entity\Product')->findOneBy(array('barcodeNumber' => $iBarcode));
            
            if($oProduct == null) {
                $oProduct = new Entity\Product();
                
                $oProduct->setName($sName);
                $oProduct->setBarcodeNumber($iBarcode);
                
                $oTag = $this->getEntityManager()->getRepository('Application\Entity\Tag')->findOneBy(array('name' => $sTag));
                if($oTag == null) {
                    $oTag = new Entity\Tag();
                    $oTag->setName($sTag);
                    
                    $this->getEntityManager()->persist($oTag);
                }
                
                $oProduct->addTag($oTag);
                
                $this->getEntityManager()->persist($oProduct);
            }
            
            $oItem = new Entity\Item();
            
            $oItem->setProduct($oProduct);
            
            $sExpiration = trim($sExpiration);
            if(!empty($sExpiration)) {
                $oItem->setExpirationDate(new \DateTime($sExpiration));
            }
            
            $bOpened = $sOpened == 'tak' ? true : false;
            $oItem->setOpened($bOpened);
            
            $oItem->setNote($sNote);
            
            $oPlace = $this->getEntityManager()->getRepository('Application\Entity\Place')->find($iPlace);
            $oItem->setPlace($oPlace);
            
            
            
            $this->getEntityManager()->persist($oItem);
            $this->getEntityManager()->flush();
            
            
            
        }
        
        exit('END');
    }
}
