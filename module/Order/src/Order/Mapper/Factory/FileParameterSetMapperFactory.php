<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Mapper\FileParameterSetMapper;
use DbSystel\DataObject\FileParameterSet;

class FileParameterSetMapperFactory implements FactoryInterface
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

        $service = new FileParameterSetMapper(
            $container->get('Zend\Db\Adapter\Adapter'),
            $entityManager
        );

        $service->setFileParameterMapper($container->get('Order\Mapper\FileParameterMapper'));

        return $service;
    }

}
