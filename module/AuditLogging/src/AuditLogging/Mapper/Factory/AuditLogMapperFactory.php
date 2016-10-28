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

        $service->setRequestModifier($serviceLocator->get('AuditLogging\Mapper\RequestModifier\AuditLogRequestModifier'));

        $service->setTableDataProcessor($serviceLocator->get('DbSystel\Utility\TableDataProcessor'));
        $service->setStringUtility($serviceLocator->get('DbSystel\Utility\StringUtility'));

        $service->setUserMapper($serviceLocator->get('Order\Mapper\UserMapper'));
        $service->setFileTransferRequestMapper($serviceLocator->get('Order\Mapper\FileTransferRequestMapper'));
        $service->setServerMapper($serviceLocator->get('Order\Mapper\ServerMapper'));
        $service->setClusterMapper($serviceLocator->get('Order\Mapper\ClusterMapper'));

        return $service;
    }

}