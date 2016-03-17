<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\BasicPhysicalConnection;
use DbSystel\DataObject\SpecificPhysicalConnectionFtgw;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\User;
use DbSystel\DataObject\Customer;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class BasicEndpointFtgwHydratorFactory implements FactoryInterface
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
        $basicEndpointHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $basicPhysicalConnectionHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $serverHydrator = $serviceLocator->get('DbSystel\Hydrator\ServerHydrator');
        $applicationHydrator = $serviceLocator->get('DbSystel\Hydrator\ApplicationHydrator');
        $userHydrator = $serviceLocator->get('DbSystel\Hydrator\UserHydrator');
        $customerHydrator = $serviceLocator->get('DbSystel\Hydrator\CustomerHydrator');

        $basicEndpointHydrator->addStrategy('basic_physical_connection',
            new GenericEntityStrategy($basicPhysicalConnectionHydrator, new SpecificPhysicalConnectionFtgw()));
        $basicEndpointHydrator->addStrategy('server', new GenericEntityStrategy($serverHydrator, new Server()));
        $basicEndpointHydrator->addStrategy('application',
            new GenericEntityStrategy($applicationHydrator, new Application()));
        $basicEndpointHydrator->addStrategy('user', new GenericEntityStrategy($userHydrator, new User()));
        $basicEndpointHydrator->addStrategy('customer', new GenericEntityStrategy($customerHydrator, new Customer()));

        $namingStrategy = new MapNamingStrategy(
            array(
                'server_place' => 'serverPlace',
                'contact_person' => 'contactPerson',
                'basic_physical_connection' => 'basicPhysicalConnection'
            ));
        $basicEndpointHydrator->setNamingStrategy($namingStrategy);

        return $basicEndpointHydrator;
    }
}
