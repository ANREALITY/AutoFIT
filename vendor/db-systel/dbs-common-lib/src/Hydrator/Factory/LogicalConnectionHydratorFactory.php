<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\Hydrator\Strategy\Entity\GenericCollectionStrategy;
use DbSystel\DataObject\PhysicalConnection;

class LogicalConnectionHydratorFactory implements FactoryInterface
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
        $logicalConnectionHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $physicalConnectionHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');

        $logicalConnectionHydrator->addStrategy('physical_connections', new GenericCollectionStrategy($physicalConnectionHydrator, new PhysicalConnection()));

        $namingStrategy = new MapNamingStrategy(array(
            'physical_connections' => 'physicalConnections',
        ));
        $logicalConnectionHydrator->setNamingStrategy($namingStrategy);

        return $logicalConnectionHydrator;
    }
}
