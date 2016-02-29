<?php
namespace DbSystel\Hydrator;

use DbSystel\DataObject\EndpointCdAs400;
use DbSystel\DataObject\PhysicalConnectionCd;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\User;
use DbSystel\DataObject\Customer;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\ServerType;

/**
 * EndpointCdAs400HydratorTest test case.
 */
class EndpointCdAs400HydratorTest extends AbstractHydratorTest
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
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new EndpointCdAs400());
        
//         $this->assertInstanceOf('DbSystel\DataObject\EndpointCdAs400', $hydratedObject);
//         $this->assertEquals(static::CHEXTURE['sku'], $hydratedObject->getSku());
//         $this->assertInstanceOf('DbSystel\DataObject\ProductType', $hydratedObject->getProductType());
//         $this->assertEquals(static::CHEXTURE['product_type_name'], $hydratedObject->getProductType()
//             ->getName());
    }

    protected function createHydrator()
    {
        $serviceManager = \Test\Bootstrap::getServiceManager();
        $hydratorManager = $serviceManager->get('HydratorManager');
        $hydrator = $hydratorManager->get('DbSystel\Hydrator\EndpointCdAs400Hydrator');
        return $hydrator;
    }

    protected function createFixtureObject()
    {
        $endpointCdAs400 = new EndpointCdAs400();
        $endpointCdAs400->setId(123);
        $physicalConnection = new PhysicalConnectionCd();
        $physicalConnection->setId(123);
        $logicalConnection = new LogicalConnection();
        $logicalConnection->setId(567);
        $physicalConnection->setLogicalConnection($logicalConnection);
        $endpointCdAs400->setPhysicalConnection($physicalConnection);
        $server = new Server();
        $server->setName('YXC123');
        $serverType = new ServerType();
        $serverType->setId(567);
        $server->setServerType($serverType);
        $endpointCdAs400->setServer($server);
        $application = new Application();
        $application->setTechnicalShortName('QWE123');
        $endpointCdAs400->setApplication($application);
        $user = new User();
        $user->setId(159);
        $endpointCdAs400->setUser($user);
        $customer = new Customer();
        $customer->setId(246);
        $endpointCdAs400->setCustomer($customer);
        return $endpointCdAs400;
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

