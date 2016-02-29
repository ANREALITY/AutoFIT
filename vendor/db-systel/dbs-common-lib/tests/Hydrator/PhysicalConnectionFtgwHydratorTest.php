<?php
namespace DbSystel\Hydrator;

use DbSystel\DataObject\PhysicalConnectionFtgw;
use DbSystel\DataObject\LogicalConnection;

/**
 * PhysicalConnectionFtgwHydrator test case.
 */
class PhysicalConnectionFtgwHydratorTest extends AbstractHydratorTest
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
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new PhysicalConnectionFtgw());
        
//         $this->assertInstanceOf('DbSystel\DataObject\PhysicalConnectionFtgw', $hydratedObject);
//         $this->assertEquals(static::CHEXTURE['sku'], $hydratedObject->getSku());
//         $this->assertInstanceOf('DbSystel\DataObject\ProductType', $hydratedObject->getProductType());
//         $this->assertEquals(static::CHEXTURE['product_type_name'], $hydratedObject->getProductType()
//             ->getName());
    }

    protected function createHydrator()
    {
        $serviceManager = \Test\Bootstrap::getServiceManager();
        $hydratorManager = $serviceManager->get('HydratorManager');
        $hydrator = $hydratorManager->get('DbSystel\Hydrator\PhysicalConnectionFtgwHydrator');
        return $hydrator;
    }

    protected function createFixtureObject()
    {
        $physicalConnection = new PhysicalConnectionFtgw();
        $physicalConnection->setId(123);
        $logicalConnection = new LogicalConnection();
        $logicalConnection->setId(567);
        $physicalConnection->setLogicalConnection($logicalConnection);
        return $physicalConnection;
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

