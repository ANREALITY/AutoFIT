<?php
namespace MasterData\Controller\Factory;

use Interop\Container\ContainerInterface;
use MasterData\Controller\OverviewController;
use Zend\ServiceManager\Factory\FactoryInterface;

class OverviewControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $clusterService = $container->get('Order\Service\ClusterService');

        $service = new OverviewController($clusterService);

        return $service;
    }

}
