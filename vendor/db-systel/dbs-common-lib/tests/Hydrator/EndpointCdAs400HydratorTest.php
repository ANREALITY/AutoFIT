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
            'id' => 159
        ],
        'customer' => [
            'id' => 246
        ]
    ];

    public function testHydrate()
    {
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new EndpointCdAs400());
        
        $this->assertEquals(static::CHEXTURE['physical_connection']['logical_connection']['id'], $hydratedObject->getPhysicalConnection()
            ->getLogicalConnection()
            ->getId());
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
        $physicalConnection->setSecurePlus(true);
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
}
