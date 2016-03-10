<?php
namespace Order\Controller\Factory;

use Order\Controller\ProcessController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProcessControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        // $orderService = $realServiceLocator->get('Order\Service\OrderService');
        // $orderForm = $realServiceLocator->get('Order\Form\OrderForm');
        // $orderDataPreparator = $realServiceLocator->get('Order\Form\DataPreparator\OrderDataPreparator');

        // return new ProcessController($orderService, $orderForm, $orderDataPreparator);
        return new ProcessController();
    }
}