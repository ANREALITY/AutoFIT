<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\ServiceInvoice;
use DbSystel\DataObject\Article;
use DbSystel\DataObject\ServiceInvoicePositionStatus;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

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
        $serviceInvoicePositionHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $serviceInvoiceHydrator = $serviceLocator->get('DbSystel\Hydrator\ServiceInvoiceHydrator');
        $articleHydrator = $serviceLocator->get('DbSystel\Hydrator\ArticleHydrator');
        $serviceInvoicePositionStatusHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');

        $serviceInvoicePositionHydrator->addStrategy('service_invoice', new GenericEntityStrategy($serviceInvoiceHydrator, new ServiceInvoice()));
        $serviceInvoicePositionHydrator->addStrategy('article', new GenericEntityStrategy($articleHydrator, new Article()));
        $serviceInvoicePositionHydrator->addStrategy('service_invoice_position_status', new GenericEntityStrategy($serviceInvoicePositionStatusHydrator, new ServiceInvoicePositionStatus()));

        $namingStrategy = new MapNamingStrategy(array(
            'order_quantity' => 'orderQuantity',
            'service_invoice' => 'serviceInvoice',
            'service_invoice_position_status' => 'serviceInvoicePositionStatus'
        ));
        $serviceInvoicePositionHydrator->setNamingStrategy($namingStrategy);

        return $serviceInvoicePositionHydrator;
    }
}
