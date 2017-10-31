<?php
namespace Order\Mapper\Factory;

use Interop\Container\ContainerInterface;
use Order\Mapper\FileTransferRequestMapper;
use Zend\ServiceManager\Factory\FactoryInterface;

class FileTransferRequestMapperFactory implements FactoryInterface
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
            ? $config['module']['order']['pagination']['items_per_page'] : null
        ;
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $service = new FileTransferRequestMapper(
            $entityManager
        );

        $service->setItemCountPerPage($itemCountPerPage);

        return $service;
    }

}