<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Hydrator\ClassMethods;
use DbSystel\Hydrator\Strategy\Entity\EntityStrategy;
use DbSystel\DataObject\ServiceInvoice;
use DbSystel\DataObject\Article;
use DbSystel\DataObject\ServiceInvoicePositionStatus;

class ServiceInvoicePositionHydratorFactory implements FactoryInterface
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
        
        $hydrator->addStrategy('service_invoice', new EntityStrategy(new ClassMethods(), new ServiceInvoice()));
        $hydrator->addStrategy('article', new EntityStrategy(new ClassMethods(), new Article()));
        $hydrator->addStrategy('service_invoice_position_status', new EntityStrategy(new ClassMethods(), new ServiceInvoicePositionStatus()));
        
        $namingStrategy = new MapNamingStrategy(array(
            'order_quantity' => 'orderQuantity',
            'service_invoice' => 'serviceInvoice',
            'service_invoice_position_status' => 'serviceInvoicePositionStatus'
        ));
        $hydrator->setNamingStrategy($namingStrategy);
        
        return $hydrator;
    }
}
