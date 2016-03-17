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
        'name' => 'YXC123',
        'server_type' => [
            'id' => 567
        ]
    ];

    public function testHydrate()
    {
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new Server());

        $this->assertEquals(static::CHEXTURE['server_type']['id'],
            $hydratedObject->getServerType()
                ->getId());
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
}
