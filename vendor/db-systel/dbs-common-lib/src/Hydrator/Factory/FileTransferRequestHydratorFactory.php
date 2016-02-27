<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Hydrator\ClassMethods;
use DbSystel\Hydrator\Strategy\Entity\EntityStrategy;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\ServiceInvoicePosition;

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
        // $parentLocator = $serviceLocator->getServiceLocator();
        $hydrator = new ClassMethods(false);

        $hydrator->addStrategy('logical_connection', new EntityStrategy(new ClassMethods(), new LogicalConnection()));
        $hydrator->addStrategy('service_invoice_position_basic', new EntityStrategy(new ClassMethods(), new ServiceInvoicePosition()));
        $hydrator->addStrategy('service_invoice_position_personal', new EntityStrategy(new ClassMethods(), new ServiceInvoicePosition()));

        $namingStrategy = new MapNamingStrategy(array(
            'change_number' => 'changeNumber',
            'logical_connection' => 'logicalConnection',
            'service_invoice_position_basic' => 'serviceInvoicePositionBasic',
            'service_invoice_position_personal' => 'serviceInvoicePositionPersonal',
        ));
        $hydrator->setNamingStrategy($namingStrategy);
        
        return $hydrator;
    }
}
