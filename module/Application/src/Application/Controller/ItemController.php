<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Application\Utils;

class ItemController extends AbstractRestfulController
{
    
    public function get($id)
    {
        $oItemModule = $this->getServiceLocator()->get('Model\Item');
        
        $aData = Utils\Serializer::entityToArray($oItemModule->get($id));
        
        return new JsonModel($aData);
    }
    
    public function getList()
    {
        $sQuery = $this->params()->fromQuery('query');
        $iLimit = $this->params()->fromQuery('limit');
        $sOrder = $this->params()->fromQuery('order');
        
        $oItemModule = $this->getServiceLocator()->get('Model\Item');
        
        $aData = Utils\Serializer::entityToArray($oItemModule->getList($sQuery, $sOrder, $iLimit));
        
        return new JsonModel($aData);
    }
    
    public function create($aData)
    {
        $oItemModel = $this->getServiceLocator()->get('Model\Item');

        return new JsonModel($oItemModel->create($aData));
    }
    
    public function delete($id) 
    {
        $oItemModel = $this->getServiceLocator()->get('Model\Item');
        
        $aResult = $oItemModel->delete($id);
        $aResponseData = Utils\Serializer::entityToArray($aResult);
        
        return new JsonModel($aResponseData);
    }
    
    public function update($id, $data)
    {
        $oItemModel = $this->getServiceLocator()->get('Model\Item');
        
        $aResult = Utils\Serializer::entityToArray($oItemModel->update($id, $data));
        
        return new JsonModel($aResult);
    }
    
}
