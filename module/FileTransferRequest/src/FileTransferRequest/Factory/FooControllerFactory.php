<?php
namespace FileTransferRequest\Factory;

use FileTransferRequest\Controller\FooController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FooControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $fooService = $realServiceLocator->get('FileTransferRequest\Service\FooService');
        
        return new FooController($fooService);
    }
}