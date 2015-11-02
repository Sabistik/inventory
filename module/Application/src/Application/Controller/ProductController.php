<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Application\Utils;

class ProductController extends AbstractRestfulController
{
    
    public function getList()
    {
        $sQuery = $this->params()->fromQuery('query');
        
        $oProduct = $this->getServiceLocator()->get('Model\Product');
        
        $aData = Utils\Serializer::entityToArray($oProduct->getList($sQuery));
        
        return new JsonModel($aData);
    }
    
    public function get($id)
    {
        $oProductModel = $this->getServiceLocator()->get('Model\Product');
        
        $oProduct = $oProductModel->getByBarcodeNumber($id);
        
        if($oProduct) {
            $aData = Utils\Serializer::entityToArray($oProduct);
            return new JsonModel($aData);
        }
        
        $this->response->setStatusCode(404);
        return new JsonModel();
    }
    
    public function update($id, $data)
    {
        $oProductModel = $this->getServiceLocator()->get('Model\Product');
        
        $aResult = Utils\Serializer::entityToArray($oProductModel->update($id, $data));
        
        return new JsonModel($aResult);
    }
}
