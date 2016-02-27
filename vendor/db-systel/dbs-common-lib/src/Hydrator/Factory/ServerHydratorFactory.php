<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Hydrator\ClassMethods;
use DbSystel\Hydrator\Strategy\Entity\EntityStrategy;
use DbSystel\DataObject\ServerType;

class ServerHydratorFactory implements FactoryInterface
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

        $hydrator->addStrategy('server_type', new EntityStrategy(new ClassMethods(), new ServerType()));

        $namingStrategy = new MapNamingStrategy(array(
            'server_type' => 'serverType',
        ));
        $hydrator->setNamingStrategy($namingStrategy);
        
        return $hydrator;
    }
}
