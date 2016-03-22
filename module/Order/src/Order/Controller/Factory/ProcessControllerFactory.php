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

        // $router = $realServiceLocator->get('router');
        // $request = $realServiceLocator->get('request');
        // $routerMatch = $router->match($request);
        // $test1 = $routerMatch->getParams();
        // $test2 = $request->getQuery();
        // $test3 = $request->getPost();

        $fileTransferRequestService = $realServiceLocator->get('Order\Service\FileTransferRequestService');
        $orderForm = $realServiceLocator->get('FormElementManager')->get('Order\Form\OrderForm');
        $fileTransferRequest = new FileTransferRequest();

        return new ProcessController($orderForm, $fileTransferRequest, $fileTransferRequestService);
    }
}