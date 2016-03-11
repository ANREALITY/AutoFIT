<?php
namespace FileTransferRequest\Controller\Factory;

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
        $dataPreparator = $realServiceLocator->get('FileTransferRequest\Form\DataPreparator\FileTransferRequestDataPreparator');

        return new EditController($fileTransferRequestService, $fileTransferRequestForm, $dataPreparator);
    }
}