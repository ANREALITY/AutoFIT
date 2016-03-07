<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\PhysicalConnection;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class PhysicalConnectionCdHydratorFactory implements FactoryInterface
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
        $physicalConnectionCdHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $physicalConnectionHydrator = $serviceLocator->get('DbSystel\Hydrator\PhysicalConnectionHydrator');

        $physicalConnectionCdHydrator->addStrategy('physical_connection', new GenericEntityStrategy($physicalConnectionHydrator, new PhysicalConnection()));

        $namingStrategy = new MapNamingStrategy(array(
            'physical_connection' => 'physicalConnection',
            'secure_plus' => 'securePlus',
        ));
        $physicalConnectionCdHydrator->setNamingStrategy($namingStrategy);

        return $physicalConnectionCdHydrator;
    }
}
