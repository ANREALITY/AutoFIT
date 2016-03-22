<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use DbSystel\DataObject\ProductType;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class ArticleHydratorFactory implements FactoryInterface
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
        $articleHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $productTypeHydrator = $serviceLocator->get('DbSystel\Hydrator\ProductTypeHydrator');
        
        $articleHydrator->addStrategy('product_type', 
            new GenericEntityStrategy($productTypeHydrator, new ProductType()));
        
        $nameMapping = array(
            'product_type' => 'productType'
        );
        $namingStrategy = new MapNamingStrategy($nameMapping);
        $articleHydrator->setNamingStrategy($namingStrategy);
        
        return $articleHydrator;
    }
}
