<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Application\Utils;

class TagController extends AbstractRestfulController
{
    
    public function getList()
    {
        $sQuery = $this->params()->fromQuery('query');
        
        $oTagModel = $this->getServiceLocator()->get('Model\Tag');
        
        $aData = Utils\Serializer::entityToArray($oTagModel->getList($sQuery));
        
        return new JsonModel($aData);
    }
    
    public function create($aData)
    {
        $oTagModel = $this->getServiceLocator()->get('Model\Tag');

        $aData = Utils\Serializer::entityToArray($oTagModel->create($aData));
        
        return new JsonModel($aData);
    }
    
    /*public function get($id)
    {
        $oProductModel = $this->getServiceLocator()->get('Model\Tag');
        
        $oProduct = $oProductModel->getByBarcodeNumber($id);
        if($oProduct) {
            $aData = Utils\Serializer::entityToArray($oProduct);
            return new JsonModel($aData);
        }
        
        $this->response->setStatusCode(404);
        return new JsonModel();
    }*/
}
