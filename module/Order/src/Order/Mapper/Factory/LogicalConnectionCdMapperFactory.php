<?php
namespace Order\Mapper\Factory;

use Order\Mapper\LogicalConnectionCdMapper;
use DbSystel\DataObject\LogicalConnection;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogicalConnectionCdMapperFactory implements FactoryInterface
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
        
        $service = new LogicalConnectionCdMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'), 
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new LogicalConnection());
        
        $connectionType = $routerMatch->getParam('connectionType');
        $physicalConnectionMapperServiceName = 'Order\Mapper\PhysicalConnection' . $connectionType . 'Mapper';
        
        $service->setPhysicalConnectionMapper($serviceLocator->get($physicalConnectionMapperServiceName));
        
        return $service;
    }

}