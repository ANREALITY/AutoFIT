<?php
namespace MasterData\Controller\Factory;

use MasterData\Controller\ClusterController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use DbSystel\DataObject\Cluster;

class ClusterControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $clusterService = $container->get('Order\Service\ClusterService');

        $formElementManager = $container->get('FormElementManager');
        $clusterForm = $formElementManager->get('MasterData\Form\ClusterForm');

        $service = new ClusterController(new Cluster(), $clusterService);
        $service->setClusterForm($clusterForm);

        return $service;
    }

}
