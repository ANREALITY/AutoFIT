<?php
namespace Order\Service\Factory;

use Order\Service\ServiceInvoicePositionService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceInvoicePositionServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ServiceInvoicePositionService($serviceLocator->get('Order\Mapper\ServiceInvoicePositionMapper'));
    }

}