<?php
namespace Order\Mvc\Controller\Plugin\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Mvc\Controller\Plugin\IsInSync;

class IsInSyncFactory implements FactoryInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();

        $synchronizationService = $realServiceLocator->get('Order\Service\SynchronizationService');

        return new IsInSync($synchronizationService);
    }

}
