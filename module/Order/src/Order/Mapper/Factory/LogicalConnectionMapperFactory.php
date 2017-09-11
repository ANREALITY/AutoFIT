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
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $service = new LogicalConnectionMapper(
            $container->get('Zend\Db\Adapter\Adapter'),
            null,
            $entityManager
        );

        $service->setPhysicalConnectionMapper($container->get('Order\Mapper\PhysicalConnectionMapper'));
        $service->setNotificationMapper($container->get('Order\Mapper\NotificationMapper'));

        return $service;
    }

}