<?php
namespace Order\Mapper\Factory;

use Order\Mapper\PhysicalConnectionFtgwMapper;
use DbSystel\DataObject\PhysicalConnectionFtgw;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhysicalConnectionFtgwMapperFactory implements FactoryInterface
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
        $service = new PhysicalConnectionFtgwMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new PhysicalConnectionFtgw());
        
        $properServiceNameDetector = $serviceLocator->get('Order\Utility\ProperServiceNameDetector');
        $endpointSourceFieldsetServiceName = $properServiceNameDetector->getEndpointSourceMapperServiceName();
        $endpointTargetFieldsetServiceName = $properServiceNameDetector->getEndpointTargetMapperServiceName();

        $service->setEndpointSourceMapper($serviceLocator->get($endpointSourceFieldsetServiceName));
        $service->setEndpointTargetMapper($serviceLocator->get($endpointTargetFieldsetServiceName));

        return $service;
    }

}