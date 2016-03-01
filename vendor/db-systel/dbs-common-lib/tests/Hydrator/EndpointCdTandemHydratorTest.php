<?php
namespace DbSystel\Hydrator;

use DbSystel\DataObject\EndpointCdTandem;
use DbSystel\DataObject\PhysicalConnectionCd;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\User;
use DbSystel\DataObject\Customer;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\ServerType;

/**
 * EndpointCdTandemHydratorTest test case.
 */
class EndpointCdTandemHydratorTest extends AbstractHydratorTest
{

    const CHEXTURE = [
        'id' => 123,
        'physical_connection' => [
            'id' => 123,
            'secure_plus' => true,
            'logical_connection' => [
                'id' => 567
            ]
        ],
        'server' => [
            'name' => 'YXC123',
            'server_type' => [
                'id' => 567
            ]
        ],
        'application' => [
            'technical_short_name' => 'QWE123'
        ],
        'user' => [
            'id' => 135
        ],
        'customer' => [
            'id' => 246
        ]
    ];

    public function testHydrate()
    {
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new EndpointCdTandem());
        
        $this->assertEquals(static::CHEXTURE['physical_connection']['logical_connection']['id'], $hydratedObject->getPhysicalConnection()
            ->getLogicalConnection()
            ->getId());
    }

    protected function createHydrator()
    {
        $serviceManager = \Test\Bootstrap::getServiceManager();
        $hydratorManager = $serviceManager->get('HydratorManager');
        $hydrator = $hydratorManager->get('DbSystel\Hydrator\EndpointCdTandemHydrator');
        return $hydrator;
    }

    protected function createFixtureObject()
    {
        $endpointCdTandem = new EndpointCdTandem();
        $endpointCdTandem->setId(123);
        $physicalConnection = new PhysicalConnectionCd();
        $physicalConnection->setId(123);
        $physicalConnection->setSecurePlus(true);
        $logicalConnection = new LogicalConnection();
        $logicalConnection->setId(567);
        $physicalConnection->setLogicalConnection($logicalConnection);
        $endpointCdTandem->setPhysicalConnection($physicalConnection);
        $server = new Server();
        $server->setName('YXC123');
        $serverType = new ServerType();
        $serverType->setId(567);
        $server->setServerType($serverType);
        $endpointCdTandem->setServer($server);
        $application = new Application();
        $application->setTechnicalShortName('QWE123');
        $endpointCdTandem->setApplication($application);
        $user = new User();
        $user->setId(135);
        $endpointCdTandem->setUser($user);
        $customer = new Customer();
        $customer->setId(246);
        $endpointCdTandem->setCustomer($customer);
        return $endpointCdTandem;
    }
}
