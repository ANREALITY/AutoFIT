<?php
namespace Order\Mapper\Factory;

use Interop\Container\ContainerInterface;
use Order\Mapper\ServiceInvoicePositionMapper;
use Zend\ServiceManager\Factory\FactoryInterface;

class ServiceInvoicePositionMapperFactory implements FactoryInterface
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

        $service = new ServiceInvoicePositionMapper(
            $container->get('Zend\Db\Adapter\Adapter'),
            $entityManager
        );

        return $service;
    }

}
