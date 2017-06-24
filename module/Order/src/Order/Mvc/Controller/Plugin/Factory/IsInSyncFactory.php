<?php
namespace Order\Mvc\Controller\Plugin\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Mvc\Controller\Plugin\IsInSync;

class IsInSyncFactory implements FactoryInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $realServiceLocator = $container->getServiceLocator();

        $synchronizationService = $realServiceLocator->get('Order\Service\SynchronizationService');

        return new IsInSync($synchronizationService);
    }

}
