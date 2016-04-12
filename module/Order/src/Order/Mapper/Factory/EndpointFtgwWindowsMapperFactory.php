<?php
namespace Order\Mapper\Factory;

use Order\Mapper\EndpointFtgwWindowsMapper;
use DbSystel\DataObject\EndpointFtgwWindows;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointFtgwWindowsMapperFactory implements FactoryInterface
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
        $service = new EndpointFtgwWindowsMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new EndpointFtgwWindows());

        $service->setServerMapper($serviceLocator->get('Order\Mapper\ServerMapper'));
        $service->setApplicationMapper($serviceLocator->get('Order\Mapper\ApplicationMapper'));
        $service->setCustomerMapper($serviceLocator->get('Order\Mapper\CustomerMapper'));

        return $service;
    }

}