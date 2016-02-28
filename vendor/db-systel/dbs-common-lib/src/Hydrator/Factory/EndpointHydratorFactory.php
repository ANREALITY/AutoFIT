<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\PhysicalConnection;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\User;
use DbSystel\DataObject\Customer;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;

class EndpointHydratorFactory implements FactoryInterface
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
        $endpointHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');

        $endpointHydrator->addStrategy('physical_connection', new GenericEntityStrategy($productTypeHydrator, new PhysicalConnection()));
        $endpointHydrator->addStrategy('server', new GenericEntityStrategy($productTypeHydrator, new Server()));
        $endpointHydrator->addStrategy('application', new GenericEntityStrategy($productTypeHydrator, new Application()));
        $endpointHydrator->addStrategy('user', new GenericEntityStrategy($productTypeHydrator, new User()));
        $endpointHydrator->addStrategy('customer', new GenericEntityStrategy($productTypeHydrator, new Customer()));

        $namingStrategy = new MapNamingStrategy(array(
            'server_place' => 'serverPlace',
            'contact_person' => 'contactPerson',
            'physical_connection' => 'physicalConnection',
        ));
        $endpointHydrator->setNamingStrategy($namingStrategy);

        return $endpointHydrator;
    }
}
