<?php
namespace DbSystel\Hydrator;

use DbSystel\DataObject\SpecificPhysicalConnectionFtgw;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\BasicPhysicalConnection;

/**
 * PhysicalConnectionFtgwHydrator test case.
 */
class PhysicalConnectionFtgwHydratorTest extends AbstractHydratorTest
{

    const CHEXTURE = [
        'physical_connection' => [
            'id' => 123,
            'logical_connection' => [
                'id' => 567
            ]
        ]
    ];

    public function testHydrate()
    {
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new PhysicalConnectionFtgw());
        
        $this->assertEquals(static::CHEXTURE['physical_connection']['logical_connection']['id'], 
            $hydratedObject->getPhysicalConnection()
                ->getLogicalConnection()
                ->getId());
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
        $physicalConnectionFtgw = new PhysicalConnectionFtgw();
        $physicalConnection = new PhysicalConnection();
        $physicalConnection->setId(123);
        $logicalConnection = new LogicalConnection();
        $logicalConnection->setId(567);
        $physicalConnection->setLogicalConnection($logicalConnection);
        $physicalConnectionFtgw->setPhysicalConnection($physicalConnection);
        return $physicalConnectionFtgw;
    }
}
