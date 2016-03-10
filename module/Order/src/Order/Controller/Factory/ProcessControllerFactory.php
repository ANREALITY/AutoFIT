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
        // $orderService = $realServiceLocator->get('Order\Service\OrderService');
        $orderForm = $realServiceLocator->get('Order\Form\OrderForm');
        $fileTransferRequestPrototype = new FileTransferRequest();
        // $orderDataPreparator = $realServiceLocator->get('Order\Form\DataPreparator\OrderDataPreparator');

        // return new ProcessController($orderService, $orderForm, $orderDataPreparator);
        return new ProcessController($orderForm, $fileTransferRequestPrototype);
    }
}