<?php
namespace Order\Service\Factory;

use Order\Service\EnvironmentService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EnvironmentServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new EnvironmentService($serviceLocator->get('Order\Mapper\EnvironmentMapper'));
    }
}