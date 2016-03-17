<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\Environment;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

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
        $applicationHydrator = $serviceLocator->get('DbSystel\Hydrator\ApplicationHydrator');
        $environmentHydrator = $serviceLocator->get('DbSystel\Hydrator\EnvironmentHydrator');

        $serviceInvoiceHydrator->addStrategy('application',
            new GenericEntityStrategy($applicationHydrator, new Application()));
        $serviceInvoiceHydrator->addStrategy('environment',
            new GenericEntityStrategy($environmentHydrator, new Environment()));

        $namingStrategy = new MapNamingStrategy(array());
        $serviceInvoiceHydrator->setNamingStrategy($namingStrategy);

        return $serviceInvoiceHydrator;
    }
}
