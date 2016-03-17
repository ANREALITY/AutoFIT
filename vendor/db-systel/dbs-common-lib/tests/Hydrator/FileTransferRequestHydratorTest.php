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
use DbSystel\DataObject\User;
use DbSystel\DataObject\SpecificPhysicalConnectionCd;
use DbSystel\DataObject\BasicPhysicalConnection;
use DbSystel\DataObject\EndpointCdTandem;
use DbSystel\DataObject\BasicEndpoint;

/**
 * FileTransferRequestHydrator test case.
 */
class FileTransferRequestHydratorTest extends AbstractHydratorTest
{

    const CHEXTURE = [
        'id' => 123,
        'logical_connection' => [
            'id' => 567,
            'physical_connections' => [
                [
                    'secure_plus' => 1,
                    'physical_connection' => [
                        'id' => 1111
                    ]
                ],
                [
                    'secure_plus' => 0,
                    'physical_connection' => [
                        'id' => 2222,
                        'endpoints' => [
                            [
                                'username' => 'foo',
                                'folder' => '/path/to/bar',
                                'endpoint' => [
                                    'id' => 777,
                                    'role' => 'target'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'service_invoice_position_basic' => [
            'number' => 'BUZ333',
            'service_invoice' => [
                'number' => 'BAR333',
                'application' => [
                    'technical_short_name' => 'QWE333'
                ],
                'environment' => [
                    'severity' => 10
                ]
            ],
            'article' => [
                'sku' => 'FOO333',
                'product_type' => [
                    'name' => 'cd'
                ]
            ],
            'service_invoice_position_status' => [
                'name' => 'YXCV333'
            ]
        ],
        'service_invoice_position_personal' => [
            'number' => 'BUZ555',
            'service_invoice' => [
                'number' => 'BAR555',
                'application' => [
                    'technical_short_name' => 'QWE555'
                ],
                'environment' => [
                    'severity' => 20
                ]
            ],
            'article' => [
                'sku' => 'FOO555',
                'product_type' => [
                    'name' => 'cd'
                ]
            ],
            'service_invoice_position_status' => [
                'name' => 'YXCV555'
            ]
        ],
        'user' => [
            'id' => 357
        ]
    ];

    public function testHydrate()
    {
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new FileTransferRequest());
        
        $this->assertEquals(
            static::CHEXTURE['service_invoice_position_basic']['service_invoice']['application']['technical_short_name'], 
            $hydratedObject->getServiceInvoicePositionBasic()
                ->getServiceInvoice()
                ->getApplication()
                ->getTechnicalShortName());
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
        $logicalConnectionPhysicalConnectionA = new PhysicalConnectionCd();
        $logicalConnectionPhysicalConnectionA->setSecurePlus(1);
        $logicalConnectionPhysicalConnectionPhysicalConnectionA = new PhysicalConnection();
        $logicalConnectionPhysicalConnectionPhysicalConnectionA->setId(1111);
        $logicalConnectionPhysicalConnectionA->setPhysicalConnection(
            $logicalConnectionPhysicalConnectionPhysicalConnectionA);
        $logicalConnectionPhysicalConnectionB = new PhysicalConnectionCd();
        $logicalConnectionPhysicalConnectionB->setSecurePlus(0);
        $logicalConnectionPhysicalConnectionPhysicalConnectionB = new PhysicalConnection();
        $logicalConnectionPhysicalConnectionPhysicalConnectionB->setId(2222);
        
        $logicalConnectionPhysicalConnectionPhysicalConnectionEndpointTandemBA = new EndpointCdTandem();
        $logicalConnectionPhysicalConnectionPhysicalConnectionEndpointTandemBA->setUsername('foo');
        $logicalConnectionPhysicalConnectionPhysicalConnectionEndpointTandemBA->setFolder('/path/to/bar');
        $logicalConnectionPhysicalConnectionB->setPhysicalConnection(
            $logicalConnectionPhysicalConnectionPhysicalConnectionB);
        $logicalConnectionPhysicalConnectionPhysicalConnectionEndpointTandemEndpointBA = new BasicEndpoint();
        $logicalConnectionPhysicalConnectionPhysicalConnectionEndpointTandemEndpointBA->setId(777);
        $logicalConnectionPhysicalConnectionPhysicalConnectionEndpointTandemEndpointBA->setRole('target');
        $logicalConnectionPhysicalConnectionPhysicalConnectionEndpointTandemBA->setEndpoint(
            $logicalConnectionPhysicalConnectionPhysicalConnectionEndpointTandemEndpointBA);
        $endpoints = [
            $logicalConnectionPhysicalConnectionPhysicalConnectionEndpointTandemBA
        ];
        $logicalConnectionPhysicalConnectionPhysicalConnectionB->setEndpoints($endpoints);
        $logicalConnectionPhysicalConnectionB->setPhysicalConnection(
            $logicalConnectionPhysicalConnectionPhysicalConnectionB);
        $physicalConnections = [
            $logicalConnectionPhysicalConnectionA,
            $logicalConnectionPhysicalConnectionB
        ];
        $logicalConnection->setPhysicalConnections($physicalConnections);
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
        $serviceInvoicePositionStatus->setName('YXCV333');
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
        $environment->setSeverity(20);
        $serviceInvoice->setEnvironment($environment);
        $serviceInvoicePositionPersonal->setServiceInvoice($serviceInvoice);
        $article = new Article();
        $article->setSku('FOO555');
        $productType = new ProductType();
        $productType->setName('cd');
        $article->setProductType($productType);
        $serviceInvoicePositionPersonal->setArticle($article);
        $serviceInvoicePositionStatus = new ServiceInvoicePositionStatus();
        $serviceInvoicePositionStatus->setName('YXCV555');
        $serviceInvoicePositionPersonal->setServiceInvoicePositionStatus($serviceInvoicePositionStatus);
        $fileTransferRequest->setServiceInvoicePositionPersonal($serviceInvoicePositionPersonal);
        $user = new User();
        $user->setId(357);
        $fileTransferRequest->setUser($user);
        return $fileTransferRequest;
    }
}
