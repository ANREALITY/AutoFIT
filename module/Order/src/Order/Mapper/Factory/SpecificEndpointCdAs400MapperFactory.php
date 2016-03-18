<?php
namespace Order\Mapper\Factory;

use Order\Mapper\SpecificEndpointCdAs400Mapper;
use DbSystel\DataObject\SpecificEndpointCdAs400;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SpecificEndpointCdAs400MapperFactory implements FactoryInterface
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
        return new SpecificEndpointCdAs400Mapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\SpecificEndpointCdAs400Hydrator'),
            new SpecificEndpointCdAs400(), $serviceLocator->get('Order\Mapper\BasicEndpointMapper'));
    }
}