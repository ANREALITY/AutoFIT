<?php
namespace FileTransferRequest\Factory;

use FileTransferRequest\Controller\EditController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EditControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $fileTransferRequestService = $realServiceLocator->get('FileTransferRequest\Service\FileTransferRequestService');
        $fileTransferRequestForm = $realServiceLocator->get('FileTransferRequest\Form\FileTransferRequestForm');
        
        return new EditController($fileTransferRequestService, $fileTransferRequestForm);
    }
}