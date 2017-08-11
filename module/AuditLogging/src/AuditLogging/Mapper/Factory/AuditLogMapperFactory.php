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
     * @param ContainerInterface $container
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $itemCountPerPage = isset($config['module']['order']['pagination']['items_per_page'])
            ? $config['module']['audit-logging']['pagination']['items_per_page'] : null
        ;

        $service = new AuditLogMapper(
            $container->get('Zend\Db\Adapter\Adapter'),
            $container->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'),
            new AuditLog(),
            $itemCountPerPage
        );

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