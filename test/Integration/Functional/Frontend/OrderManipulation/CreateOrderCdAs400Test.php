<?php
namespace Test\Integration\Functional\Frontend\OrderManipulation;

use DbSystel\DataObject\AbstractEndpoint;
use DbSystel\DataObject\FileTransferRequest;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\PhysicalConnectionCd;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Http\Request;
use Zend\Hydrator\ClassMethods;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class CreateOrderCdAs400Test extends AbstractHttpControllerTestCase
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;
    /** @var Adapter */
    protected $dbAdapter;

    protected function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../../../config/application.config.php'
        );
        parent::setUp();
        $this->dbAdapter = $this->getApplicationServiceLocator()->get('Zend\Db\Adapter\Adapter');
    }

    public function testCdAs400()
    {
        $dispatchUrl = '/order/process/create/cd/cdas400/cdas400';
        $fixturesRootFolder = $this->getApplicationServiceLocator()->get('config')['fixtures']['folder'];
        $fixturesFolder = $fixturesRootFolder . '/' . 'order-create-form-data';
        $fixtureFile = 'cd_cdas400_cdas400.json';
        $fixtureFilePath = $fixturesFolder . '/' . $fixtureFile;
        $fixtureJson = file_get_contents($fixtureFilePath);
        $dispatchParams = json_decode($fixtureJson, true);
        $this->dispatch($dispatchUrl, Request::METHOD_POST, $dispatchParams);

        $this->assertFileTransferRequest($dispatchParams);
        $this->assertLogicalConnection($dispatchParams);
        $this->assertPhysicalConnectionCd($dispatchParams);
        $this->assertPhysicalConnectionCdEndToEnd($dispatchParams);
        $this->assertEndpointSource($dispatchParams);
        $this->assertEndpointTarget($dispatchParams);
        $this->assertEndpointCdAs400Source($dispatchParams);
        $this->assertEndpointCdAs400Target($dispatchParams);
    }

    protected function assertFileTransferRequest(array $dispatchParams)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('file_transfer_request');
        $select->where(['file_transfer_request.id = ?' => 1]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['change_number'],
            $data['change_number']
        );
        $this->assertEquals(FileTransferRequest::STATUS_EDIT, $data['status']);
    }

    protected function assertLogicalConnection(array $dispatchParams)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('logical_connection');
        $select->where(['logical_connection.id = ?' => 1]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();

        $this->assertEquals(
            strtolower($dispatchParams['file_transfer_request']['logical_connection']['type']),
            strtolower($data['type'])
        );
    }

    protected function assertPhysicalConnectionCd(array $dispatchParams)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('physical_connection');
        $select->where(['physical_connection.id = ?' => 1]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();

        $this->assertEquals(
            strtolower($dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['type']),
            strtolower($data['type'])
        );
        $this->assertEquals(
            strtolower($dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['role']),
            strtolower($data['role'])
        );
    }

    protected function assertPhysicalConnectionCdEndToEnd(array $dispatchParams)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('physical_connection');
        $select->where(['physical_connection.id = ?' => 1]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['secure_plus'],
            $data['secure_plus']
        );
    }

    protected function assertPhysicalConnectionFtgwEndToMiddle(array $dispatchParams)
    {
        // @todo
    }

    protected function assertPhysicalConnectionFtgwMiddleToEnd(array $dispatchParams)
    {
        // @todo
    }

    protected function assertEndpointSource(array $dispatchParams)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('endpoint');
        $select->where(['endpoint.id = ?' => 1]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['contact_person'],
            $data['contact_person']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['server_place'],
            $data['server_place']
        );
    }

    protected function assertEndpointTarget(array $dispatchParams)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('endpoint');
        $select->where(['endpoint.id = ?' => 2]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['contact_person'],
            $data['contact_person']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['server_place'],
            $data['server_place']
        );
    }

    protected function assertEndpointCdAs400Source(array $dispatchParams)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('endpoint_cd_as400');
        $select->where(['endpoint_cd_as400.endpoint_id = ?' => 1]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['username'],
            $data['username']
        );
    }

    protected function assertEndpointCdAs400Target(array $dispatchParams)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('endpoint_cd_as400');
        $select->where(['endpoint_cd_as400.endpoint_id = ?' => 2]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['username'],
            $data['username']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['folder'],
            $data['folder']
        );
    }

}
