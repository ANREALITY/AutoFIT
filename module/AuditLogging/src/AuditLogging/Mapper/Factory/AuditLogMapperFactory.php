<?php
namespace AuditLogging\Mapper\Factory;

use AuditLogging\Mapper\AuditLogMapper;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuditLogMapperFactory implements FactoryInterface
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
            ? $config['module']['audit-logging']['pagination']['items_per_page'] : null
        ;
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $service = new AuditLogMapper(
            $entityManager
        );

        $service->setItemCountPerPage($itemCountPerPage);

        return $service;
    }

}