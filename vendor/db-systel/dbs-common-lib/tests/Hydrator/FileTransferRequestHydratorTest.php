<?php
namespace DbSystel\Hydrator;

use DbSystel\DataObject\FileTransferRequest;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\ServiceInvoicePosition;
use DbSystel\DataObject\ServiceInvoice;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\Environment;
use DbSystel\DataObject\Article;
use DbSystel\DataObject\ProductType;
use DbSystel\DataObject\ServiceInvoicePositionStatus;

/**
 * FileTransferRequestHydrator test case.
 */
class FileTransferRequestHydratorTest extends AbstractHydratorTest
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
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new FileTransferRequest());
        
//         $this->assertInstanceOf('DbSystel\DataObject\FileTransferRequest', $hydratedObject);
//         $this->assertEquals(static::CHEXTURE['sku'], $hydratedObject->getSku());
//         $this->assertInstanceOf('DbSystel\DataObject\ProductType', $hydratedObject->getProductType());
//         $this->assertEquals(static::CHEXTURE['product_type_name'], $hydratedObject->getProductType()
//             ->getName());
    }

    protected function createHydrator()
    {
        $serviceManager = \Test\Bootstrap::getServiceManager();
        $hydratorManager = $serviceManager->get('HydratorManager');
        $hydrator = $hydratorManager->get('DbSystel\Hydrator\FileTransferRequestHydrator');
        return $hydrator;
    }

    protected function createFixtureObject()
    {
        $fileTransferRequest = new FileTransferRequest();
        $fileTransferRequest->setId(123);
        $logicalConnection = new LogicalConnection();
        $logicalConnection->setId(567);
        $fileTransferRequest->setLogicalConnection($logicalConnection);
        $serviceInvoicePositionBasic = new ServiceInvoicePosition();
        $serviceInvoicePositionBasic->setNumber('BUZ333');
        $serviceInvoice = new ServiceInvoice();
        $serviceInvoice->setNumber('BAR333');
        $application = new Application();
        $application->setTechnicalShortName('QWE333');
        $serviceInvoice->setApplication($application);
        $environment = new Environment();
        $environment->setSeverity(10);
        $serviceInvoice->setEnvironment($environment);
        $serviceInvoicePositionBasic->setServiceInvoice($serviceInvoice);
        $article = new Article();
        $article->setSku('FOO333');
        $productType = new ProductType();
        $productType->setName('cd');
        $article->setProductType($productType);
        $serviceInvoicePositionBasic->setArticle($article);
        $serviceInvoicePositionStatus = new ServiceInvoicePositionStatus();
        $serviceInvoicePositionStatus->setName('YXCV');
        $serviceInvoicePositionBasic->setServiceInvoicePositionStatus($serviceInvoicePositionStatus);
        $fileTransferRequest->setServiceInvoicePositionBasic($serviceInvoicePositionBasic);
        $serviceInvoicePositionPersonal = new ServiceInvoicePosition();
        $serviceInvoicePositionPersonal->setNumber('BUZ555');
        $serviceInvoice = new ServiceInvoice();
        $serviceInvoice->setNumber('BAR555');
        $application = new Application();
        $application->setTechnicalShortName('QWE555');
        $serviceInvoice->setApplication($application);
        $environment = new Environment();
        $environment->setSeverity(10);
        $serviceInvoice->setEnvironment($environment);
        $serviceInvoicePositionPersonal->setServiceInvoice($serviceInvoice);
        $article = new Article();
        $article->setSku('FOO555');
        $productType = new ProductType();
        $productType->setName('cd');
        $article->setProductType($productType);
        $serviceInvoicePositionPersonal->setArticle($article);
        $serviceInvoicePositionStatus = new ServiceInvoicePositionStatus();
        $serviceInvoicePositionStatus->setName('YXCV');
        $serviceInvoicePositionPersonal->setServiceInvoicePositionStatus($serviceInvoicePositionStatus);
        $fileTransferRequest->setServiceInvoicePositionPersonal($serviceInvoicePositionPersonal);
        return $fileTransferRequest;
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

