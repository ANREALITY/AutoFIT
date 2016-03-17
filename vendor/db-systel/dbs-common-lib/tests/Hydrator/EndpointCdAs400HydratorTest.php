<?php
namespace DbSystel\Hydrator;

use DbSystel\DataObject\EndpointCdAs400;
use DbSystel\DataObject\SpecificPhysicalConnectionCd;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\User;
use DbSystel\DataObject\Customer;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\ServerType;
use DbSystel\DataObject\BasicEndpoint;
use DbSystel\DataObject\BasicPhysicalConnection;

/**
 * EndpointCdAs400HydratorTest test case.
 */
class EndpointCdAs400HydratorTest extends AbstractHydratorTest
{

    const CHEXTURE = [
        'endpoint' => [
            'id' => 123,
            'physical_connection' => [
                'secure_plus' => true
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
            'customer' => [
                'id' => 246
            ]
        ]
    ];

    public function testHydrate()
    {
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new EndpointCdAs400());

        $this->assertEquals(static::CHEXTURE['endpoint']['server']['server_type']['id'],
            $hydratedObject->getEndpoint()
                ->getServer()
                ->getServerType()
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
        $endpoint = new BasicEndpoint();
        $endpoint->setId(123);
        $physicalConnectionCd = new PhysicalConnectionCd();
        $physicalConnectionCd->setSecurePlus(true);
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
        $customer = new Customer();
        $customer->setId(246);
        $endpoint->setCustomer($customer);
        $endpointCdAs400->setEndpoint($endpoint);
        return $endpointCdAs400;
    }
}
