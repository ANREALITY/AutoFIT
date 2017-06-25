<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Mapper\ProtocolSetMapper;
use DbSystel\DataObject\ProtocolSet;

class ProtocolSetMapperFactory implements FactoryInterface
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
        $service = new ProtocolSetMapper($container->get('Zend\Db\Adapter\Adapter'),
            $container->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new ProtocolSet());

        $service->setProtocolMapper($container->get('Order\Mapper\ProtocolMapper'));
        $service->setTableDataProcessor($container->get('DbSystel\Utility\TableDataProcessor'));
        $service->setStringUtility($container->get('DbSystel\Utility\StringUtility'));

        return $service;
    }

}
