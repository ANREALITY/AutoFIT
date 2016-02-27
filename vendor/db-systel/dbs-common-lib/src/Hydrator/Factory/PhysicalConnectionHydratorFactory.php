<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Hydrator\ClassMethods;
use DbSystel\Hydrator\Strategy\Entity\EntityStrategy;
use DbSystel\DataObject\LogicalConnection;

class PhysicalConnectionHydratorFactory implements FactoryInterface
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

        $namingStrategy = new MapNamingStrategy(array(
            'logical_connection' => 'logicalConnection',
        ));
        $hydrator->setNamingStrategy($namingStrategy);
        
        return $hydrator;
    }
}
