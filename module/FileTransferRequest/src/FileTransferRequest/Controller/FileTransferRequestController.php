<?php

namespace FileTransferRequest\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FileTransferRequestController extends AbstractActionController
{

    public function newAction()
    {
        return new ViewModel();
    }

}

