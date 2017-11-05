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

        $formElementManager = $container->get('FormElementManager');
        $searchForm = $formElementManager->get('MasterData\Form\SearchForm');

        $service = new OverviewController($clusterService);
        $service->setSearchForm($searchForm);

        return $service;
    }

}
