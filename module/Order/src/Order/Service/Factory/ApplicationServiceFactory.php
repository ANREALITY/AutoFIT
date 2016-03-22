<?php
namespace Order\Service\Factory;

use Order\Service\ApplicationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApplicationServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ApplicationService($serviceLocator->get('Order\Mapper\ApplicationMapper'));
    }
}