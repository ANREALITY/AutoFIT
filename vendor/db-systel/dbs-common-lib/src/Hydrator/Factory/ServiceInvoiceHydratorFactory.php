<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\Environment;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;

class ServiceInvoiceHydratorFactory implements FactoryInterface
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
        $serviceInvoiceHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');

        $serviceInvoiceHydrator->addStrategy('application', new GenericEntityStrategy($productTypeHydrator, new Application()));
        $serviceInvoiceHydrator->addStrategy('environment', new GenericEntityStrategy($productTypeHydrator, new Environment()));

        $namingStrategy = new MapNamingStrategy(array());
        $serviceInvoiceHydrator->setNamingStrategy($namingStrategy);

        return $serviceInvoiceHydrator;
    }
}
