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
        'product_type_name' => 'cd',
        'sku' => 'FOO1234'
    ];

    public function testExtract()
    {
        $extractedData = $this->getHydrator()->extract($this->createFixtureObject());
        
        $this->assertArrayHasKey('sku', $extractedData);
        $this->assertEquals(static::CHEXTURE['sku'], $extractedData['sku']);
        $this->assertArraySubset([
            'product_type' => [
                'name' => static::CHEXTURE['product_type_name']
            ]
        ], $extractedData);
    }

    public function testHydrate()
    {
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new Article());
        
        $this->assertInstanceOf('DbSystel\DataObject\Article', $hydratedObject);
        $this->assertEquals(static::CHEXTURE['sku'], $hydratedObject->getSku());
        $this->assertInstanceOf('DbSystel\DataObject\ProductType', $hydratedObject->getProductType());
        $this->assertEquals(static::CHEXTURE['product_type_name'], $hydratedObject->getProductType()
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
        $article->setDescription('Bar article description');
        $article->setType('baz');
        $productType = new ProductType();
        $productType->setName('cd');
        $article->setProductType($productType);
        return $article;
    }

    protected function createFixtureArray()
    {
        return [
            'sku' => 'FOO1234',
            'description' => 'Bar article description',
            'type' => 'baz',
            'product_type' => [
                'name' => 'cd',
                'long_name' => null
            ]
        ];
    }
}

