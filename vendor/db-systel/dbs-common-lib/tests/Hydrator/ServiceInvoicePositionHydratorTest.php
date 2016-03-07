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
        'number' => 'BUZ123',
        'service_invoice' => [
            'number' => 'BAR123',
            'application' => [
                'technical_short_name' => 'QWE123'
            ],
            'environment' => [
                'severity' => 40
            ]
        ],
        'article' => [
            'sku' => 'FOO1234',
            'product_type' => [
                'name' => 'cd'
            ]
        ],
        'service_invoice_position_status' => [
            'name' => 'YXCV'
        ]
    ];

    public function testHydrate()
    {
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new ServiceInvoicePosition());

        $this->assertEquals(static::CHEXTURE['service_invoice']['environment']['severity'], $hydratedObject->getServiceInvoice()
            ->getEnvironment()
            ->getSeverity());
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
        $environment->setSeverity(40);
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
}

