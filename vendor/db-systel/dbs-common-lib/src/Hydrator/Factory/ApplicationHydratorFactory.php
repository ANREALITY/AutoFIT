<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class ApplicationHydratorFactory implements FactoryInterface
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
            'technical_short_name' => 'technicalShortName',
            'technical_id' => 'technicalId'
        );
        $namingStrategy = new MapNamingStrategy($nameMapping);
        $productTypeHydrator->setNamingStrategy($namingStrategy);
        
        return $productTypeHydrator;
    }
}
