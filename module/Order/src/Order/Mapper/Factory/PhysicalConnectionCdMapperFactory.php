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

        $service = new PhysicalConnectionCdMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new PhysicalConnectionCd());

        $endpointSourceType = $routerMatch->getParam('endpointSourceType');
        $endpointSourceFieldsetServiceName = 'Order\Mapper\Endpoint' . $endpointSourceType . 'Mapper';
        $endpointTargetType = $routerMatch->getParam('endpointTargetType');
        $endpointTargetFieldsetServiceName = 'Order\Mapper\Endpoint' . $endpointTargetType . 'Mapper';

        $service->setEndpointSourceMapper($serviceLocator->get($endpointSourceFieldsetServiceName));
        $service->setEndpointTargetMapper($serviceLocator->get($endpointTargetFieldsetServiceName));

        return $service;
    }

}