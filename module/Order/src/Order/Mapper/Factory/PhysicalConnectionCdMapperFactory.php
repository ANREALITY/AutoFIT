<?php
namespace Order\Mapper\Factory;

use Order\Mapper\PhysicalConnectionCdMapper;
use DbSystel\DataObject\PhysicalConnectionCd;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhysicalConnectionCdMapperFactory implements FactoryInterface
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

        $endpointSourceType = $routerMatch->getParam('endpointSourceType');
        $endpointSourceFieldsetServiceName = 'Order\Mapper\Endpoint' . $endpointSourceType . 'Mapper';
        $endpointTargetType = $routerMatch->getParam('endpointTargetType');
        $endpointTargetFieldsetServiceName = 'Order\Mapper\Endpoint' . $endpointTargetType . 'Mapper';

        return new PhysicalConnectionCdMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'), 
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new PhysicalConnectionCd(), 
            $serviceLocator->get($endpointSourceFieldsetServiceName), 
            $serviceLocator->get($endpointTargetFieldsetServiceName));
    }
}