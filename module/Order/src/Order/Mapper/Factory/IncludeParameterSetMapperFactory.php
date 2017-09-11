<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Mapper\IncludeParameterSetMapper;
use DbSystel\DataObject\IncludeParameterSet;

class IncludeParameterSetMapperFactory implements FactoryInterface
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

        $service = new IncludeParameterSetMapper(
            $container->get('Zend\Db\Adapter\Adapter'),
            null,
            $entityManager
        );

        $service->setIncludeParameterMapper($container->get('Order\Mapper\IncludeParameterMapper'));

        return $service;
    }

}
