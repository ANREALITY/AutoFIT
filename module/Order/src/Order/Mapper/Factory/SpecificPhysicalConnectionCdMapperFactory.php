<?php
namespace Order\Mapper\Factory;

use Order\Mapper\SpecificPhysicalConnectionCdMapper;
use DbSystel\DataObject\SpecificPhysicalConnectionCd;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SpecificPhysicalConnectionCdMapperFactory implements FactoryInterface
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
        return new SpecificPhysicalConnectionCdMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\SpecificPhysicalConnectionCdHydrator'),
            new SpecificPhysicalConnectionCd(), $serviceLocator->get('Order\Mapper\BasicPhysicalConnectionMapper'));
    }
}