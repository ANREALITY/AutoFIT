<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Mapper\ProtocolSetMapper;
use DbSystel\DataObject\ProtocolSet;

class ProtocolSetMapperFactory implements FactoryInterface
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
        $service = new ProtocolSetMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new ProtocolSet());

        $service->setProtocolMapper($serviceLocator->get('Order\Mapper\ProtocolMapper'));
        $service->setArrayProcessor($serviceLocator->get('DbSystel\Utility\ArrayProcessor'));

        return $service;
    }

}
