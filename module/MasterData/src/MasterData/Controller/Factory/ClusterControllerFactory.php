<?php
namespace MasterData\Controller\Factory;

use MasterData\Controller\ClusterController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\Cluster;

class ClusterControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $clusterService = $realServiceLocator->get('Order\Service\ClusterService');

        $formElementManager = $realServiceLocator->get('FormElementManager');
        $clusterForm = $formElementManager->get('MasterData\Form\ClusterForm');

        $service = new ClusterController(new Cluster(), $clusterService);
        $service->setClusterForm($clusterForm);

        return $service;
    }

}
