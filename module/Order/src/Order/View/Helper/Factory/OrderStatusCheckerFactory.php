<?php
namespace Order\View\Helper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\View\Helper\OrderStatusChecker;

class OrderStatusCheckerFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     * @see FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $orderStatusConfig = isset($config['status']['order']) ? $config['status']['order'] : [];
        
        return new OrderStatusChecker($orderStatusConfig);
    }

}
