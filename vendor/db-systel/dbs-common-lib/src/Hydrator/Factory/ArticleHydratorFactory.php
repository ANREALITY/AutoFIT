<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Hydrator\ClassMethods;
use DbSystel\Hydrator\Strategy\Entity\EntityStrategy;
use DbSystel\DataObject\ProductType;

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
        // $parentLocator = $serviceLocator->getServiceLocator();
        $hydrator = new ClassMethods(false);

        $hydrator->addStrategy('product_type', new EntityStrategy(new ClassMethods(), new ProductType()));

        $namingStrategy = new MapNamingStrategy(array(
            'product_type' => 'productType'
        ));
        $hydrator->setNamingStrategy($namingStrategy);
        
        return $hydrator;
    }
}
