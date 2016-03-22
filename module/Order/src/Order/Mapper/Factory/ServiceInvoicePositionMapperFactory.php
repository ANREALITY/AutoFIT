<?php
namespace Order\Mapper\Factory;

use Order\Mapper\ServiceInvoicePositionMapper;
use DbSystel\DataObject\ServiceInvoicePosition;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceInvoicePositionMapperFactory implements FactoryInterface
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
        return new ServiceInvoicePositionMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'),
            new ServiceInvoicePosition());
    }
}