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
            $service->setOrderForm(
                $realServiceLocator->get('FormElementManager')
                    ->get('Order\Form\OrderForm'));
        }
        
        return $service;
    }

}
