<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Hydrator\ClassMethods;
use DbSystel\Hydrator\Strategy\Entity\EntityStrategy;
use DbSystel\DataObject\PhysicalConnection;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\User;
use DbSystel\DataObject\Customer;

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
        // $parentLocator = $serviceLocator->getServiceLocator();
        $hydrator = new ClassMethods(false);

        $hydrator->addStrategy('physical_connection', new EntityStrategy(new ClassMethods(), new PhysicalConnection()));
        $hydrator->addStrategy('server', new EntityStrategy(new ClassMethods(), new Server()));
        $hydrator->addStrategy('application', new EntityStrategy(new ClassMethods(), new Application()));
        $hydrator->addStrategy('user', new EntityStrategy(new ClassMethods(), new User()));
        $hydrator->addStrategy('customer', new EntityStrategy(new ClassMethods(), new Customer()));

        $namingStrategy = new MapNamingStrategy(array(
            'server_place' => 'serverPlace',
            'contact_person' => 'contactPerson',
            'physical_connection' => 'physicalConnection',
        ));
        $hydrator->setNamingStrategy($namingStrategy);
        
        return $hydrator;
    }
}
