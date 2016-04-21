<?php
namespace Order\Mapper\Factory;

use Order\Mapper\NotificationMapper;
use DbSystel\DataObject\Notification;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NotificationMapperFactory implements FactoryInterface
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
        $service = new NotificationMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new Notification());

        return $service;
    }

}