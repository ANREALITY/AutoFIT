<?php
namespace Order\Mapper\Factory;

use Order\Mapper\FileTransferRequestMapper;
use DbSystel\DataObject\FileTransferRequest;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use DbSystel\DataObject\User;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\Notification;

class FileTransferRequestMapperFactory implements FactoryInterface
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
            ? $config['module']['order']['pagination']['items_per_page'] : null
        ;
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $service = new FileTransferRequestMapper(
            $container->get('Zend\Db\Adapter\Adapter'),
            $container->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'),
            new FileTransferRequest(),
            $itemCountPerPage,
            $entityManager
        );

        $service->setUserPrototype(new User());
        $service->setLogicalConnectionPrototype(new LogicalConnection());
        $service->setNotificationPrototype(new Notification());

        $service->setLogicalConnectionMapper($container->get('Order\Mapper\LogicalConnectionMapper'));
        $service->setServiceInvoicePositionMapper($container->get('Order\Mapper\ServiceInvoicePositionMapper'));
        $service->setUserMapper($container->get('Order\Mapper\UserMapper'));

        $service->setRequestModifier($container->get('Order\Mapper\RequestModifier\FileTransferRequestRequestModifier'));

        $service->setTableDataProcessor($container->get('DbSystel\Utility\TableDataProcessor'));
        $service->setStringUtility($container->get('DbSystel\Utility\StringUtility'));

        return $service;
    }

}