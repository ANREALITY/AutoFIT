<?php
namespace Order\Mapper\Factory;

use Interop\Container\ContainerInterface;
use Order\Mapper\ClusterMapper;
use Zend\ServiceManager\Factory\FactoryInterface;

class ClusterMapperFactory implements FactoryInterface
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

        $service = new ClusterMapper(
            $container->get('Zend\Db\Adapter\Adapter'),
            $entityManager
        );

        $service->setServerMapper($container->get('Order\Mapper\ServerMapper'));

        return $service;
    }

}
