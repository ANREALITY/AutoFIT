<?php
namespace Order\Mapper\Factory;

use Order\Mapper\BasicEndpointMapper;
use DbSystel\DataObject\BasicEndpoint;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BasicEndpointMapperFactory implements FactoryInterface
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
        return new BasicEndpointMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'), 
            $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\BasicEndpointHydrator'), new BasicEndpoint(), 
            $serviceLocator->get('Order\Mapper\ServerMapper'), $serviceLocator->get('Order\Mapper\ApplicationMapper'), 
            $serviceLocator->get('Order\Mapper\CustomerMapper'));
    }
}