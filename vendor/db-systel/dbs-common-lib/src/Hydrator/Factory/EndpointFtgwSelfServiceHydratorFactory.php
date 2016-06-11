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
use DbSystel\DataObject\Protocol;
use DbSystel\Hydrator\Strategy\Entity\GenericCollectionStrategy;

class EndpointFtgwSelfServiceHydratorFactory implements FactoryInterface
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
        $endpointFtgwSelfServiceHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $protocolHydrator = $serviceLocator->get('DbSystel\Hydrator\ProtocolHydrator');

        $endpointFtgwSelfServiceHydrator->addStrategy('protocols', new GenericCollectionStrategy($protocolHydrator, new Protocol()));

        // no naming map
        
        return $endpointFtgwSelfServiceHydrator;
    }
}
