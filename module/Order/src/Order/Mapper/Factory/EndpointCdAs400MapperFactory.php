<?php
namespace Order\Mapper\Factory;

use Order\Mapper\EndpointCdAs400Mapper;
use DbSystel\DataObject\EndpointCdAs400;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointCdAs400MapperFactory implements FactoryInterface
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
        $service = new EndpointCdAs400Mapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new EndpointCdAs400());

        $service->setServerMapper($serviceLocator->get('Order\Mapper\ServerMapper'));
        $service->setApplicationMapper($serviceLocator->get('Order\Mapper\ApplicationMapper'));
        $service->setCustomerMapper($serviceLocator->get('Order\Mapper\CustomerMapper'));

        return $service;
    }

}