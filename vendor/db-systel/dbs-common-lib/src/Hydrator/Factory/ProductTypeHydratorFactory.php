<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class ProductTypeHydratorFactory implements FactoryInterface
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
        $productTypeHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        
        // no strategies
        
        $nameMapping = array(
            'long_name' => 'longName'
        );
        $namingStrategy = new MapNamingStrategy($nameMapping);
        $productTypeHydrator->setNamingStrategy($namingStrategy);
        
        return $productTypeHydrator;
    }
}
