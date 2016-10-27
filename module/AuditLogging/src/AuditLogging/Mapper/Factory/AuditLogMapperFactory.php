<?php
namespace AuditLogging\Mapper\Factory;

use AuditLogging\Mapper\AuditLogMapper;
use DbSystel\DataObject\AuditLog;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuditLogMapperFactory implements FactoryInterface
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
        $service = new AuditLogMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new AuditLog());

        $service->setUserMapper($serviceLocator->get('Order\Mapper\UserMapper'));

        return $service;
    }

}