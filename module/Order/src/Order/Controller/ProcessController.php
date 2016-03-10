<?php

namespace Order\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProcessController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function createAction()
    {
        return new ViewModel(['foo' => 'bar']);
    }


}

