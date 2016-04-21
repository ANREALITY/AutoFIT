<?php
namespace Order\Mapper\Factory;

use Order\Mapper\CustomerMapper;
use DbSystel\DataObject\Customer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CustomerMapperFactory implements FactoryInterface
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
        $service = new CustomerMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new Customer());

        return $service;
    }

}