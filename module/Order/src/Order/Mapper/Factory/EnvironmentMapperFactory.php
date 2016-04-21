<?php
namespace Order\Mapper\Factory;

use Order\Mapper\EnvironmentMapper;
use DbSystel\DataObject\Environment;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EnvironmentMapperFactory implements FactoryInterface
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
        $service = new EnvironmentMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'), 
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new Environment());

        return $service;
    }

}