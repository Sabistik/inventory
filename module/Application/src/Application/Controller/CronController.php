<?php


namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CronController extends AbstractActionController
{
    public function indexAction()
    {
        $oItemModule = $this->getServiceLocator()->get('Model\Item');
        
        return new ViewModel();
    }
}
