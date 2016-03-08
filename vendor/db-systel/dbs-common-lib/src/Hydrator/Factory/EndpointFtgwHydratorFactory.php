<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\PhysicalConnection;
use DbSystel\DataObject\PhysicalConnectionFtgw;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\User;
use DbSystel\DataObject\Customer;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class EndpointFtgwHydratorFactory implements FactoryInterface
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
        $physicalConnectionHydrator = $serviceLocator->get('DbSystel\Hydrator\PhysicalConnectionFtgwHydrator');
        $serverHydrator = $serviceLocator->get('DbSystel\Hydrator\ServerHydrator');
        $applicationHydrator = $serviceLocator->get('DbSystel\Hydrator\ApplicationHydrator');
        $userHydrator = $serviceLocator->get('DbSystel\Hydrator\UserHydrator');
        $customerHydrator = $serviceLocator->get('DbSystel\Hydrator\CustomerHydrator');

        $endpointHydrator->addStrategy('physical_connection', new GenericEntityStrategy($physicalConnectionHydrator, new PhysicalConnectionFtgw()));
        $endpointHydrator->addStrategy('server', new GenericEntityStrategy($serverHydrator, new Server()));
        $endpointHydrator->addStrategy('application', new GenericEntityStrategy($applicationHydrator, new Application()));
        $endpointHydrator->addStrategy('user', new GenericEntityStrategy($userHydrator, new User()));
        $endpointHydrator->addStrategy('customer', new GenericEntityStrategy($customerHydrator, new Customer()));

        $namingStrategy = new MapNamingStrategy(array(
            'server_place' => 'serverPlace',
            'contact_person' => 'contactPerson',
            'physical_connection' => 'physicalConnection',
        ));
        $endpointHydrator->setNamingStrategy($namingStrategy);

        return $endpointHydrator;
    }
}
