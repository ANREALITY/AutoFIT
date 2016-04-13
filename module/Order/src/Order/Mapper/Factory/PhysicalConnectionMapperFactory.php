<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Mapper\PhysicalConnectionMapper;

class PhysicalConnectionMapperFactory implements FactoryInterface
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
        $service = new PhysicalConnectionMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'));

        $service->setEndpointSourceMapper($serviceLocator->get('Order\Mapper\EndpointMapper'));
        $service->setEndpointTargetMapper($serviceLocator->get('Order\Mapper\EndpointMapper'));
    
        return $service;
    }

}
