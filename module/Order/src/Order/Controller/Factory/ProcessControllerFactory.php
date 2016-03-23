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

        $routerMathParamsForOrderForm = [
            'connectionType',
            'endpointSourceType',
            'endpointTargetType'
        ];
        $formNeeded = count(array_intersect($routerMathParamsForOrderForm, array_keys($routerMatch->getParams()))) ===
             count($routerMathParamsForOrderForm);
        
        $service = new ProcessController(new FileTransferRequest(), 
            $realServiceLocator->get('Order\Service\FileTransferRequestService'));

        if ($formNeeded) {
            $service->setOrderForm($realServiceLocator->get('FormElementManager')
                ->get('Order\Form\OrderForm'));
        }
        
        return $service;
    }

}
