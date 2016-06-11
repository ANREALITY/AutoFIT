<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use DbSystel\Hydrator\ProtocolHydrator;

class ProtocolHydratorFactory implements FactoryInterface
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
        $protocolHydrator = new ProtocolHydrator();

        // no strategies

        // no naming map

        return $protocolHydrator;
    }
}
