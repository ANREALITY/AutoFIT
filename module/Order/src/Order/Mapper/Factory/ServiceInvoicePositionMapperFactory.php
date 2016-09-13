<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Mapper\ServiceInvoicePositionMapper;
use DbSystel\DataObject\ServiceInvoicePosition;

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
        $service = new ServiceInvoicePositionMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new ServiceInvoicePosition());

        $service->setServiceInvoiceMapper($serviceLocator->get('Order\Mapper\ServiceInvoiceMapper'));
        $service->setTableDataProcessor($serviceLocator->get('DbSystel\Utility\TableDataProcessor'));

        return $service;
    }

}
