<?php
namespace DbSystel\Hydrator;

use DbSystel\DataObject\Server;
use DbSystel\DataObject\ServerType;

/**
 * ServerHydrator test case.
 */
class ServerHydratorTest extends AbstractHydratorTest
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
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new Server());
        
//         $this->assertInstanceOf('DbSystel\DataObject\Server', $hydratedObject);
//         $this->assertEquals(static::CHEXTURE['sku'], $hydratedObject->getSku());
//         $this->assertInstanceOf('DbSystel\DataObject\ProductType', $hydratedObject->getProductType());
//         $this->assertEquals(static::CHEXTURE['product_type_name'], $hydratedObject->getProductType()
//             ->getName());
    }

    protected function createHydrator()
    {
        $serviceManager = \Test\Bootstrap::getServiceManager();
        $hydratorManager = $serviceManager->get('HydratorManager');
        $hydrator = $hydratorManager->get('DbSystel\Hydrator\ServerHydrator');
        return $hydrator;
    }

    protected function createFixtureObject()
    {
        $server = new Server();
        $server->setName('YXC123');
        $serverType = new ServerType();
        $serverType->setId(567);
        $server->setServerType($serverType);
        return $server;
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

