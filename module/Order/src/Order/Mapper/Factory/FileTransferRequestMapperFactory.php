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
            $itemCountPerPage,
            $entityManager
        );

        $service->setLogicalConnectionMapper($container->get('Order\Mapper\LogicalConnectionMapper'));
        $service->setUserMapper($container->get('Order\Mapper\UserMapper'));

        return $service;
    }

}