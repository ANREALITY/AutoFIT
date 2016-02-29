<?php
namespace DbSystel\Hydrator;

use DbSystel\DataObject\ServiceInvoicePosition;
use DbSystel\DataObject\ServiceInvoice;
use DbSystel\DataObject\Article;
use DbSystel\DataObject\ServiceInvoicePositionStatus;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\Environment;
use DbSystel\DataObject\ProductType;

/**
 * ServiceInvoicePositionHydratorTest test case.
 */
class ServiceInvoicePositionHydratorTest extends AbstractHydratorTest
{

    const CHEXTURE = [
        'product_type_name' => 'cd',
        'sku' => 'FOO1234'
    ];

    public function testExtract()
    {
        $extractedData = $this->getHydrator()->extract($this->createFixtureObject());
        
//         $this->assertArrayHasKey('sku', $extractedData);
//         $this->assertEquals(static::CHEXTURE['sku'], $extractedData['sku']);
//         $this->assertArraySubset([
//             'product_type' => [
//                 'name' => static::CHEXTURE['product_type_name']
//             ]
//         ], $extractedData);
    }

    public function testHydrate()
    {
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new ServiceInvoicePosition());
        
//         $this->assertInstanceOf('DbSystel\DataObject\ServiceInvoicePosition', $hydratedObject);
//         $this->assertEquals(static::CHEXTURE['sku'], $hydratedObject->getSku());
//         $this->assertInstanceOf('DbSystel\DataObject\ProductType', $hydratedObject->getProductType());
//         $this->assertEquals(static::CHEXTURE['product_type_name'], $hydratedObject->getProductType()
//             ->getName());
    }

    protected function createHydrator()
    {
        $serviceManager = \Test\Bootstrap::getServiceManager();
        $hydratorManager = $serviceManager->get('HydratorManager');
        $hydrator = $hydratorManager->get('DbSystel\Hydrator\ServiceInvoicePositionHydrator');
        return $hydrator;
    }

    protected function createFixtureObject()
    {
        $serviceInvoicePosition = new ServiceInvoicePosition();
        $serviceInvoicePosition->setNumber('BUZ123');
        $serviceInvoice = new ServiceInvoice();
        $serviceInvoice->setNumber('BAR123');
        $application = new Application();
        $application->setTechnicalShortName('QWE123');
        $serviceInvoice->setApplication($application);
        $environment = new Environment();
        $environment->setSeverity(10);
        $serviceInvoice->setEnvironment($environment);
        $serviceInvoicePosition->setServiceInvoice($serviceInvoice);
        $article = new Article();
        $article->setSku('FOO1234');
        $productType = new ProductType();
        $productType->setName('cd');
        $article->setProductType($productType);
        $serviceInvoicePosition->setArticle($article);
        $serviceInvoicePositionStatus = new ServiceInvoicePositionStatus();
        $serviceInvoicePositionStatus->setName('YXCV');
        $serviceInvoicePosition->setServiceInvoicePositionStatus($serviceInvoicePositionStatus);
        return $serviceInvoicePosition;
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

