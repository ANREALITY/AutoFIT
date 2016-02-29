<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\PhysicalConnectionCd;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\User;
use DbSystel\DataObject\Customer;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class EndpointCdTandemHydratorFactory implements FactoryInterface
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
        $endpointCdTandemHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $physicalConnectionCdHydrator = $serviceLocator->get('DbSystel\Hydrator\PhysicalConnectionCdHydrator');
        $serverHydrator = $serviceLocator->get('DbSystel\Hydrator\ServerHydrator');
        $applicationHydrator = $serviceLocator->get('DbSystel\Hydrator\ApplicationHydrator');
        $userHydrator = $serviceLocator->get('DbSystel\Hydrator\UserHydrator');
        $customerHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');

        $endpointCdTandemHydrator->addStrategy('physical_connection', new GenericEntityStrategy($physicalConnectionCdHydrator, new PhysicalConnectionCd()));
        $endpointCdTandemHydrator->addStrategy('server', new GenericEntityStrategy($serverHydrator, new Server()));
        $endpointCdTandemHydrator->addStrategy('application', new GenericEntityStrategy($applicationHydrator, new Application()));
        $endpointCdTandemHydrator->addStrategy('user', new GenericEntityStrategy($userHydrator, new User()));
        $endpointCdTandemHydrator->addStrategy('customer', new GenericEntityStrategy($customerHydrator, new Customer()));

        $namingStrategy = new MapNamingStrategy(array(
            'server_place' => 'serverPlace',
            'contact_person' => 'contactPerson',
            'physical_connection' => 'physicalConnectionCd',
        ));
        $endpointCdTandemHydrator->setNamingStrategy($namingStrategy);

        return $endpointCdTandemHydrator;
    }
}
