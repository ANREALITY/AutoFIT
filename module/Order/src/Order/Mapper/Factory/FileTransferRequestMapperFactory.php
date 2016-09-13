<?php
namespace Order\Mapper\Factory;

use Order\Mapper\FileTransferRequestMapper;
use DbSystel\DataObject\FileTransferRequest;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\User;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\Notification;

class FileTransferRequestMapperFactory implements FactoryInterface
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
        $service = new FileTransferRequestMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new FileTransferRequest());

        $service->setUserPrototype(new User());
        $service->setLogicalConnectionPrototype(new LogicalConnection());
        $service->setNotificationPrototype(new Notification());
        $service->setLogicalConnectionMapper($serviceLocator->get('Order\Mapper\LogicalConnectionMapper'));
        $service->setServiceInvoicePositionMapper($serviceLocator->get('Order\Mapper\ServiceInvoicePositionMapper'));
        $service->setUserMapper($serviceLocator->get('Order\Mapper\UserMapper'));
        $service->setTableDataProcessor($serviceLocator->get('DbSystel\Utility\TableDataProcessor'));

        return $service;
    }

}