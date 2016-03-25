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

        $router = $realServiceLocator->get('router');
        $request = $realServiceLocator->get('request');
        $routerMatch = $router->match($request);

        $service = new ProcessController(new FileTransferRequest(),
            $realServiceLocator->get('Order\Service\FileTransferRequestService'));

        $routerMatchParamsForOrderForm = [
            'connectionType',
            'endpointSourceType',
            'endpointTargetType'
        ];
        $isOrderRequest = count(array_intersect($routerMatchParamsForOrderForm, array_keys($routerMatch->getParams()))) ===
             count($routerMatchParamsForOrderForm);

        if ($isOrderRequest) {
            $service->setOrderForm(
                $realServiceLocator->get('FormElementManager')
                    ->get('Order\Form\OrderForm'));
        }

        return $service;
    }

}
