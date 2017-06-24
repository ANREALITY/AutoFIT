<?php
namespace AuditLogging\Mapper\Factory;

use AuditLogging\Mapper\AuditLogMapper;
use DbSystel\DataObject\AuditLog;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class AuditLogMapperFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new AuditLogMapper($container->get('Zend\Db\Adapter\Adapter'),
            $container->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new AuditLog());

        $service->setRequestModifier($container->get('AuditLogging\Mapper\RequestModifier\AuditLogRequestModifier'));

        $service->setTableDataProcessor($container->get('DbSystel\Utility\TableDataProcessor'));
        $service->setStringUtility($container->get('DbSystel\Utility\StringUtility'));

        $service->setUserMapper($container->get('Order\Mapper\UserMapper'));
        $service->setFileTransferRequestMapper($container->get('Order\Mapper\FileTransferRequestMapper'));
        $service->setServerMapper($container->get('Order\Mapper\ServerMapper'));
        $service->setClusterMapper($container->get('Order\Mapper\ClusterMapper'));

        return $service;
    }

}