<?php
namespace DbSystel\Hydrator;

use DbSystel\DataObject\Article;
use DbSystel\DataObject\ProductType;

/**
 * ArticleHydrator test case.
 */
class ArticleHydratorTest extends AbstractHydratorTest
{

    const CHEXTURE = [
        'sku' => 'FOO1234',
        'product_type' => [
            'name' => 'cd'
        ]
    ];

    public function testHydrate()
    {
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new Article());
        
        $this->assertEquals(static::CHEXTURE['product_type']['name'], $hydratedObject->getProductType()
            ->getName());
    }

    protected function createHydrator()
    {
        $serviceManager = \Test\Bootstrap::getServiceManager();
        $hydratorManager = $serviceManager->get('HydratorManager');
        $hydrator = $hydratorManager->get('DbSystel\Hydrator\ArticleHydrator');
        return $hydrator;
    }

    protected function createFixtureObject()
    {
        $article = new Article();
        $article->setSku('FOO1234');
        $productType = new ProductType();
        $productType->setName('cd');
        $article->setProductType($productType);
        return $article;
    }
}
