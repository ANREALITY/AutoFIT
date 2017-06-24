<?php
namespace Order\Mvc\Controller\Plugin\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Mvc\Controller\Plugin\OrderStatusChecker;

class OrderStatusCheckerFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     * @see FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $realServiceLocator = $container->getServiceLocator();

        $config = $realServiceLocator->get('Config');
        $orderStatusConfig = isset($config['status']['order']) ? $config['status']['order'] : [];
        
        return new OrderStatusChecker($orderStatusConfig);
    }

}
