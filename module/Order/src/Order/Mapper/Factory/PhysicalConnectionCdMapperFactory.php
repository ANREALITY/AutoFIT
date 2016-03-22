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
        // @todo make it dynamic!
        $endpointSourceType = 'CdAs400';
        if ($endpointSourceType === 'CdAs400') {
            $endpointSourceFieldsetServiceName = 'Order\Mapper\EndpointCdAs400Mapper';
        } elseif ($endpointSourceType === 'CdTandem') {
            $endpointSourceFieldsetServiceName = 'Order\Mapper\EndpointCdTandemMapper';
        } // ...
        $endpointTargetType = 'CdAs400';
        if ($endpointTargetType === 'CdAs400') {
            $endpointTargetFieldsetServiceName = 'Order\Mapper\EndpointCdAs400Mapper';
        } elseif ($endpointTargetType === 'CdTandem') {
            $endpointTargetFieldsetServiceName = 'Order\Mapper\EndpointCdTandemMapper';
        } // ...

        return new PhysicalConnectionCdMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new PhysicalConnectionCd(),
            $serviceLocator->get($endpointSourceFieldsetServiceName),
            $serviceLocator->get($endpointTargetFieldsetServiceName));
    }
}