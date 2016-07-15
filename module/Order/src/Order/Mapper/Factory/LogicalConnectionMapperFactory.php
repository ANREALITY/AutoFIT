<?php
namespace Order\Mapper\Factory;

use Order\Mapper\LogicalConnectionMapper;
use DbSystel\DataObject\LogicalConnection;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogicalConnectionMapperFactory implements FactoryInterface
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
        $service = new LogicalConnectionMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new LogicalConnection());

        $service->setPhysicalConnectionMapper($serviceLocator->get('Order\Mapper\PhysicalConnectionMapper'));
        $service->setNotificationMapper($serviceLocator->get('Order\Mapper\NotificationMapper'));
        $service->setArrayProcessor($serviceLocator->get('DbSystel\Utility\ArrayProcessor'));

        return $service;
    }

}