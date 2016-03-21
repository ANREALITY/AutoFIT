<?php
namespace DbSystel\Hydrator\Factory;

use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\AbstractEndpoint;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\Customer;
use DbSystel\DataObject\PhysicalConnectionCd;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\User;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;

class EndpointCdAs400HydratorFactory implements FactoryInterface
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
        $endpointCdAs400Hydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $physicalConnectionHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $serverHydrator = $serviceLocator->get('DbSystel\Hydrator\ServerHydrator');
        $applicationHydrator = $serviceLocator->get('DbSystel\Hydrator\ApplicationHydrator');
        $userHydrator = $serviceLocator->get('DbSystel\Hydrator\UserHydrator');
        $customerHydrator = $serviceLocator->get('DbSystel\Hydrator\CustomerHydrator');
        
        $endpointCdAs400Hydrator->addStrategy('physical_connection', 
            new GenericEntityStrategy($physicalConnectionHydrator, new PhysicalConnectionCd()));
        $endpointCdAs400Hydrator->addStrategy('server', new GenericEntityStrategy($serverHydrator, new Server()));
        $endpointCdAs400Hydrator->addStrategy('application', 
            new GenericEntityStrategy($applicationHydrator, new Application()));
        $endpointCdAs400Hydrator->addStrategy('user', new GenericEntityStrategy($userHydrator, new User()));
        $endpointCdAs400Hydrator->addStrategy('customer', new GenericEntityStrategy($customerHydrator, new Customer()));
        
        $namingStrategy = new MapNamingStrategy(
            array(
                'server_place' => 'serverPlace',
                'contact_person' => 'contactPerson',
                'physical_connection' => 'physicalConnection'
            ));
        $endpointCdAs400Hydrator->setNamingStrategy($namingStrategy);
        
        return $endpointCdAs400Hydrator;
    }
}
