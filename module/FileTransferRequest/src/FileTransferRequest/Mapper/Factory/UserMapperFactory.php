<?php
namespace FileTransferRequest\Mapper\Factory;

use FileTransferRequest\Mapper\UserMapper;
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
        return new UserMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'), $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\UserHydrator'), new User());
    }
}