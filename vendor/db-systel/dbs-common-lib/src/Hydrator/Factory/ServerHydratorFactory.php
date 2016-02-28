<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\ServerType;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;

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
        $serverHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');

        $serverHydrator->addStrategy('server_type', new GenericEntityStrategy($productTypeHydrator, new ServerType()));

        $namingStrategy = new MapNamingStrategy(array(
            'server_type' => 'serverType',
        ));
        $serverHydrator->setNamingStrategy($namingStrategy);

        return $serverHydrator;
    }
}
