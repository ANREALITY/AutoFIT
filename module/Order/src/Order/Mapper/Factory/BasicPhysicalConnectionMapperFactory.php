<?php
namespace Order\Mapper\Factory;

use Order\Mapper\BasicPhysicalConnectionMapper;
use DbSystel\DataObject\BasicPhysicalConnection;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BasicPhysicalConnectionMapperFactory implements FactoryInterface
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
        return new BasicPhysicalConnectionMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'), 
            $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\BasicPhysicalConnectionHydrator'), 
            new BasicPhysicalConnection(),
            $serviceLocator->get('Order\Mapper\SpecificEndpointCdAs400Mapper'));
    }
}
