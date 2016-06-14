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
        $isOrderEditRequest = $requestAnalyzer->isOrderEditRequest();
        $isStartRequest = $requestAnalyzer->isStartRequest();
        $properServiceNameDetector = $realServiceLocator->get('Order\Utility\ProperServiceNameDetector');
        $connectionType = $properServiceNameDetector->getConnectionType();
        $endpointSourceType = $properServiceNameDetector->getEndpointSourceType();
        $endpointTargetType = $properServiceNameDetector->getEndpointTargetType();

        $fileTransferRequestService = $realServiceLocator->get('Order\Service\FileTransferRequestService');
        $fileTransferRequest = $realServiceLocator->get('DbSystel\DataObject\FileTransferRequest');
        $service = new ProcessController($fileTransferRequest, $fileTransferRequestService);

        if ($isOrderRequest || $isOrderEditRequest) {
            $formElementManager = $realServiceLocator->get('FormElementManager');
            $orderForm = $formElementManager->get('Order\Form\OrderForm');
            $service->setOrderForm($orderForm);
            $service->setConnectionType($connectionType);
            $service->setEndpointSourceType($endpointSourceType);
            $service->setEndpointTargetType($endpointTargetType);
        } elseif ($isStartRequest) {
            $service->setConnectionType($connectionType);
        }

        $authenticationService = $realServiceLocator->get('AuthenticationService');
        $service->setAuthenticationService($authenticationService);
        $synchronizationService = $realServiceLocator->get('Order\Service\SynchronizationService');
        $service->setSynchronizationService($synchronizationService);

        return $service;
    }

}
