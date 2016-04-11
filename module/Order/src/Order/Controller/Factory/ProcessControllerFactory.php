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
        
        $requestAnalyzer = $realServiceLocator->get('Order\Utility\RequestAnalyzer');
        $isOrderRequest = $requestAnalyzer->isOrderRequest();
        
        $service = new ProcessController(new FileTransferRequest(), 
            $realServiceLocator->get('Order\Service\FileTransferRequestService'), $requestAnalyzer->getConnectionType(), 
            $requestAnalyzer->getEndpointSourceType(), $requestAnalyzer->getEndpointTargetType());
        
        if ($isOrderRequest) {
            $formElementManager = $realServiceLocator->get('FormElementManager');
            $orderForm = $formElementManager->get('Order\Form\OrderForm');
            $service->setOrderForm($orderForm);
        }
        
        return $service;
    }

}
