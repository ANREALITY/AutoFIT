<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\Hydrator\Strategy\Entity\GenericCollectionStrategy;
use DbSystel\DataObject\SpecificPhysicalConnectionCd;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

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
        $specificPhysicalConnectionHydrator = $serviceLocator->get(
            'DbSystel\Hydrator\SpecificPhysicalConnectionCdHydrator');

        // @todo AbstractFactory needed!!!
        // $logicalConnectionHydrator->addStrategy('specificPhysicalConnection', new GenericCollectionStrategy($specificPhysicalConnectionHydrator, new AbstractBasicPhysicalConnection()));
        // $logicalConnectionHydrator->addStrategy('specificPhysical_connections', new GenericCollectionStrategy($specificPhysicalConnectionHydrator, new SpecificPhysicalConnectionCd()));
        $logicalConnectionHydrator->addStrategy('specific_physical_connections',
            new GenericCollectionStrategy($specificPhysicalConnectionHydrator, new SpecificPhysicalConnectionCd()));

        $namingStrategy = new MapNamingStrategy(
            array(
                'specific_physical_connections' => 'specificPhysicalConnections'
            ));
        $logicalConnectionHydrator->setNamingStrategy($namingStrategy);

        return $logicalConnectionHydrator;
    }
}
