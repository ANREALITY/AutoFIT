<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Hydrator\ClassMethods;
use DbSystel\Hydrator\Strategy\Entity\EntityStrategy;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\Environment;

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
        // $parentLocator = $serviceLocator->getServiceLocator();
        $hydrator = new ClassMethods(false);

        $hydrator->addStrategy('application', new EntityStrategy(new ClassMethods(), new Application()));
        $hydrator->addStrategy('environment', new EntityStrategy(new ClassMethods(), new Environment()));

        $namingStrategy = new MapNamingStrategy(array());
        $hydrator->setNamingStrategy($namingStrategy);
        
        return $hydrator;
    }
}
