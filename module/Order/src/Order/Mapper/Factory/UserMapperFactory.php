<?php
namespace Order\Mapper\Factory;

use Order\Mapper\UserMapper;
use DbSystel\DataObject\User;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserMapperFactory implements FactoryInterface
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
        $service = new UserMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new User());

        return $service;
    }

}