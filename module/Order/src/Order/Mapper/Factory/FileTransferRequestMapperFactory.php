<?php
namespace Order\Mapper\Factory;

use Order\Mapper\FileTransferRequestMapper;
use DbSystel\DataObject\FileTransferRequest;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FileTransferRequestMapperFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $router = $serviceLocator->get('router');
        $request = $serviceLocator->get('request');
        $routerMatch = $router->match($request);

        $connectionType = $routerMatch->getParam('connectionType');
        $logicalConnectionMapperServiceName = 'Order\Mapper\LogicalConnection' . $connectionType . 'Mapper';

        return new FileTransferRequestMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'),
            new FileTransferRequest(), $serviceLocator->get($logicalConnectionMapperServiceName),
            $serviceLocator->get('Order\Mapper\UserMapper'));
    }
}