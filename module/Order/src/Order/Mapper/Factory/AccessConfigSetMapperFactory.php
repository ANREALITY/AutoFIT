<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Mapper\AccessConfigSetMapper;
use DbSystel\DataObject\AccessConfigSet;

class AccessConfigSetMapperFactory implements FactoryInterface
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
        $service = new AccessConfigSetMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new AccessConfigSet());

        $service->setAccessConfigMapper($serviceLocator->get('Order\Mapper\AccessConfigMapper'));
        $service->setArrayProcessor($serviceLocator->get('DbSystel\Utility\ArrayProcessor'));

        return $service;
    }

}
