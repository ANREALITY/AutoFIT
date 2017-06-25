<?php
namespace Order\Mapper\Factory;

use Order\Mapper\LogicalConnectionMapper;
use DbSystel\DataObject\LogicalConnection;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class LogicalConnectionMapperFactory implements FactoryInterface
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
        $service = new LogicalConnectionMapper($container->get('Zend\Db\Adapter\Adapter'),
            $container->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new LogicalConnection());

        $service->setPhysicalConnectionMapper($container->get('Order\Mapper\PhysicalConnectionMapper'));
        $service->setNotificationMapper($container->get('Order\Mapper\NotificationMapper'));
        $service->setTableDataProcessor($container->get('DbSystel\Utility\TableDataProcessor'));
        $service->setStringUtility($container->get('DbSystel\Utility\StringUtility'));

        return $service;
    }

}