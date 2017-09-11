<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Mapper\PhysicalConnectionMapper;

class PhysicalConnectionMapperFactory implements FactoryInterface
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

        $service = new PhysicalConnectionMapper(
            $container->get('Zend\Db\Adapter\Adapter'),
            null,
            $entityManager
        );

        $service->setEndpointMapper($container->get('Order\Mapper\EndpointMapper'));

        return $service;
    }

}
