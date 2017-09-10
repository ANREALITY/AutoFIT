<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Mapper\AccessConfigSetMapper;
use DbSystel\DataObject\AccessConfigSet;

class AccessConfigSetMapperFactory implements FactoryInterface
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

        $service = new AccessConfigSetMapper(
            $container->get('Zend\Db\Adapter\Adapter'),
            $container->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'),
            new AccessConfigSet(),
            null,
            $entityManager
        );

        $service->setAccessConfigMapper($container->get('Order\Mapper\AccessConfigMapper'));

        return $service;
    }

}
