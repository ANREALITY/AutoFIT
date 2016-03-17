<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\BasicPhysicalConnection;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class SpecificPhysicalConnectionFtgwHydratorFactory implements FactoryInterface
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
        $specificPhysicalConnectionFtgwHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $basicPhysicalConnectionHydrator = $serviceLocator->get('DbSystel\Hydrator\BasicPhysicalConnectionHydrator');

        $specificPhysicalConnectionFtgwHydrator->addStrategy('basic_physical_connection',
            new GenericEntityStrategy($basicPhysicalConnectionHydrator, new BasicPhysicalConnection()));

        $namingStrategy = new MapNamingStrategy(
            array(
                'basic_physical_connection' => 'basicPhysicalConnection'
            ));
        $specificPhysicalConnectionFtgwHydrator->setNamingStrategy($namingStrategy);

        return $specificPhysicalConnectionFtgwHydrator;
    }
}
