<?php
namespace MasterData\Controller\Factory;

use Interop\Container\ContainerInterface;
use MasterData\Controller\AjaxController;
use Order\Service\ClusterServiceInterface;
use Order\Service\ServerServiceInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AjaxControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ServerServiceInterface $serverService */
        $serverService = $container->get('Order\Service\ServerService');
        /** @var ClusterServiceInterface $clusterService */
        $clusterService = $container->get('Order\Service\ClusterService');

        $service = new AjaxController($serverService, $clusterService);

        return $service;
    }

}