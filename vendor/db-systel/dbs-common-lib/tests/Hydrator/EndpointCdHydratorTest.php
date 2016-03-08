<?php
namespace DbSystel\Hydrator;

use DbSystel\DataObject\Endpoint;
use DbSystel\DataObject\PhysicalConnectionCd;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\User;
use DbSystel\DataObject\Customer;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\ServerType;
use DbSystel\DataObject\PhysicalConnection;

/**
 * EndpointHydratorTest test case.
 */
class EndpointCdHydratorTest extends AbstractHydratorTest
{

    const CHEXTURE = [
        'id' => 123,
        'physical_connection' => [
            'secure_plus' => true,
            'physical_connection' => [
                'id' => 123,
                'logical_connection' => [
                    'id' => 567
                ]
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
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new Endpoint());

        $this->assertEquals(static::CHEXTURE['physical_connection']['physical_connection']['logical_connection']['id'],
            $hydratedObject->getPhysicalConnection()
                ->getPhysicalConnection()
                ->getLogicalConnection()
                ->getId());
    }

    protected function createHydrator()
    {
        $serviceManager = \Test\Bootstrap::getServiceManager();
        $hydratorManager = $serviceManager->get('HydratorManager');
        $hydrator = $hydratorManager->get('DbSystel\Hydrator\EndpointCdHydrator');
        return $hydrator;
    }

    protected function createFixtureObject()
    {
        $endpoint = new Endpoint();
        $endpoint->setId(123);
        $physicalConnectionCd = new PhysicalConnectionCd();
        $physicalConnectionCd->setSecurePlus(true);
        $physicalConnection = new PhysicalConnection();
        $physicalConnection->setId(123);
        $logicalConnection = new LogicalConnection();
        $logicalConnection->setId(567);
        $physicalConnection->setLogicalConnection($logicalConnection);
        $physicalConnectionCd->setPhysicalConnection($physicalConnection);
        $endpoint->setPhysicalConnection($physicalConnectionCd);
        $server = new Server();
        $server->setName('YXC123');
        $serverType = new ServerType();
        $serverType->setId(567);
        $server->setServerType($serverType);
        $endpoint->setServer($server);
        $application = new Application();
        $application->setTechnicalShortName('QWE123');
        $endpoint->setApplication($application);
        $user = new User();
        $user->setId(135);
        $endpoint->setUser($user);
        $customer = new Customer();
        $customer->setId(246);
        $endpoint->setCustomer($customer);
        return $endpoint;
    }
}
