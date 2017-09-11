<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Mapper\EndpointMapper;

class EndpointMapperFactory implements FactoryInterface
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

        $service = new EndpointMapper(
            $container->get('Zend\Db\Adapter\Adapter'),
            null,
            $entityManager
        );

        $service->setEndpointServerConfigMapper($container->get('Order\Mapper\EndpointServerConfigMapper'));
        $service->setExternalServerMapper($container->get('Order\Mapper\ExternalServerMapper'));
        $service->setCustomerMapper($container->get('Order\Mapper\CustomerMapper'));
        $service->setIncludeParameterSetMapper($container->get('Order\Mapper\IncludeParameterSetMapper'));
        $service->setProtocolSetMapper($container->get('Order\Mapper\ProtocolSetMapper'));
        $service->setFileParameterSetMapper($container->get('Order\Mapper\FileParameterSetMapper'));
        $service->setAccessConfigSetMapper($container->get('Order\Mapper\AccessConfigSetMapper'));
        $service->setProtocolMapper($container->get('Order\Mapper\ProtocolMapper'));
        $service->setEndpointClusterConfigMapper($container->get('Order\Mapper\EndpointClusterConfigMapper'));

        return $service;
    }

}
