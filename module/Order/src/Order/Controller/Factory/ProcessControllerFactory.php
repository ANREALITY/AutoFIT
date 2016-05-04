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

        $service = new ProcessController(new FileTransferRequest(),
            $realServiceLocator->get('Order\Service\FileTransferRequestService'));

        $requestAnalyzer = $realServiceLocator->get('Order\Utility\RequestAnalyzer');
        $isOrderRequest = $requestAnalyzer->isOrderRequest();
        $isStartRequest = $requestAnalyzer->isStartRequest();

        if ($isOrderRequest) {
            $formElementManager = $realServiceLocator->get('FormElementManager');
            $orderForm = $formElementManager->get('Order\Form\OrderForm');
            $service->setOrderForm($orderForm);
            $service->setConnectionType($requestAnalyzer->getConnectionType());
            $service->setEndpointSourceType($requestAnalyzer->getEndpointSourceType());
            $service->setEndpointTargetType($requestAnalyzer->getEndpointTargetType());
        } elseif ($isStartRequest) {
            $service->setConnectionType($requestAnalyzer->getConnectionType());
        }

        return $service;
    }

}
