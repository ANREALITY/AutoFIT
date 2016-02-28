<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\ServiceInvoicePosition;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;

class FileTransferRequestHydratorFactory implements FactoryInterface
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
        $fileTransferRequestHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');

        $fileTransferRequestHydrator->addStrategy('logical_connection', new GenericEntityStrategy($productTypeHydrator, new LogicalConnection()));
        $fileTransferRequestHydrator->addStrategy('service_invoice_position_basic', new GenericEntityStrategy($productTypeHydrator, new ServiceInvoicePosition()));
        $fileTransferRequestHydrator->addStrategy('service_invoice_position_personal', new GenericEntityStrategy($productTypeHydrator, new ServiceInvoicePosition()));

        $namingStrategy = new MapNamingStrategy(array(
            'change_number' => 'changeNumber',
            'logical_connection' => 'logicalConnection',
            'service_invoice_position_basic' => 'serviceInvoicePositionBasic',
            'service_invoice_position_personal' => 'serviceInvoicePositionPersonal',
        ));
        $fileTransferRequestHydrator->setNamingStrategy($namingStrategy);

        return $fileTransferRequestHydrator;
    }
}
