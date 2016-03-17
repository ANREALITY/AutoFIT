<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\BasicPhysicalConnection;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class SpecificPhysicalConnectionCdHydratorFactory implements FactoryInterface
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
        $specificPhysicalConnectionCdHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $basicPhysicalConnectionHydrator = $serviceLocator->get('DbSystel\Hydrator\BasicPhysicalConnectionHydrator');

        $specificPhysicalConnectionCdHydrator->addStrategy('basic_physical_connection', new GenericEntityStrategy($basicPhysicalConnectionHydrator, new BasicPhysicalConnection()));

        $namingStrategy = new MapNamingStrategy(array(
            'basic_physical_connection' => 'basicPhysicalConnection',
            'secure_plus' => 'securePlus',
        ));
        $specificPhysicalConnectionCdHydrator->setNamingStrategy($namingStrategy);

        return $specificPhysicalConnectionCdHydrator;
    }
}
