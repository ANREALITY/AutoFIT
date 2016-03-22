<?php
namespace DbSystel\Hydrator;

use DbSystel\DataObject\SpecificPhysicalConnectionCd;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\BasicPhysicalConnection;

/**
 * PhysicalConnectionCdHydrator test case.
 */
class PhysicalConnectionCdHydratorTest extends AbstractHydratorTest
{

    const CHEXTURE = [
        'secure_plus' => true,
        'physical_connection' => [
            'id' => 123,
            'logical_connection' => [
                'id' => 567
            ]
        ]
    ];

    public function testHydrate()
    {
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new PhysicalConnectionCd());
        
        $this->assertEquals(static::CHEXTURE['physical_connection']['logical_connection']['id'], 
            $hydratedObject->getPhysicalConnection()
                ->getLogicalConnection()
                ->getId());
    }

    protected function createHydrator()
    {
        $serviceManager = \Test\Bootstrap::getServiceManager();
        $hydratorManager = $serviceManager->get('HydratorManager');
        $hydrator = $hydratorManager->get('DbSystel\Hydrator\PhysicalConnectionCdHydrator');
        return $hydrator;
    }

    protected function createFixtureObject()
    {
        $physicalConnectionCd = new PhysicalConnectionCd();
        $physicalConnectionCd->setSecurePlus(true);
        $physicalConnection = new PhysicalConnection();
        $physicalConnection->setId(123);
        $logicalConnection = new LogicalConnection();
        $logicalConnection->setId(567);
        $physicalConnection->setLogicalConnection($logicalConnection);
        $physicalConnectionCd->setPhysicalConnection($physicalConnection);
        return $physicalConnectionCd;
    }
}
