<?php
namespace Order\Mapper\Factory;

use Order\Mapper\EndpointFtgwSelfServiceMapper;
use DbSystel\DataObject\EndpointFtgwSelfService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointFtgwSelfServiceMapperFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new EndpointFtgwSelfServiceMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new EndpointFtgwSelfService());

        $service->setServerMapper($serviceLocator->get('Order\Mapper\ServerMapper'));
        $service->setApplicationMapper($serviceLocator->get('Order\Mapper\ApplicationMapper'));
        $service->setCustomerMapper($serviceLocator->get('Order\Mapper\CustomerMapper'));

        return $service;
    }

}