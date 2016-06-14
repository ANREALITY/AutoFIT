<?php
namespace Order\View\Helper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\View\Helper\OrderStatusChecker;

class OrderStatusCheckerFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     * @see FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();

        $config = $realServiceLocator->get('Config');
        $orderStatusConfig = isset($config['status']['order']) ? $config['status']['order'] : [];
        
        return new OrderStatusChecker($orderStatusConfig);
    }

}
