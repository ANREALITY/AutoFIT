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

        $service->setEndpointSourceMapper($serviceLocator->get('Order\Mapper\EndpointMapper'));
        $service->setEndpointTargetMapper($serviceLocator->get('Order\Mapper\EndpointMapper'));

        return $service;
    }

}