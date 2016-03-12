<?php
namespace Order\Controller\Factory;

use Order\Controller\ProcessController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\FileTransferRequest;

class ProcessControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $fileTransferRequestService = $realServiceLocator->get('Order\Service\FileTransferRequestService');
        $orderForm = $realServiceLocator->get('FormElementManager')->get('Order\Form\OrderForm');
        $fileTransferRequest = new FileTransferRequest();
        // $orderDataPreparator = $realServiceLocator->get('Order\Form\DataPreparator\OrderDataPreparator');

        // return new ProcessController($orderService, $orderForm, $orderDataPreparator);
        return new ProcessController($orderForm, $fileTransferRequest, $fileTransferRequestService);
    }
}