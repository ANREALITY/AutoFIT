<?php
namespace Test\Integration\Functional\Frontend\OrderManipulation;

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
        $fixtureFile = 'CD_CdAs400_CdAs400.json';
        $fixtureFilePath = $fixturesFolder . '/' . $fixtureFile;
        $fixtureJson = file_get_contents($fixtureFilePath);
        $dispatchParams = json_decode($fixtureJson, true);
        $this->dispatch($dispatchUrl, Request::METHOD_POST, $dispatchParams);

        $this->assertFileTransferRequest($dispatchParams);
        $this->assertLogicalConnection($dispatchParams);
        $this->assertPhysicalConnectionCdEndToEnd($dispatchParams);
    }

    protected function assertFileTransferRequest(array $dispatchParams)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('file_transfer_request');
        $select->where(['file_transfer_request.id = ?' => 1]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();
        $hydrator = new ClassMethods();
        $prototype = new FileTransferRequest();
        /** @var FileTransferRequest $dataObject */
        $dataObject = $hydrator->hydrate($data, $prototype);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['change_number'],
            $dataObject->getChangeNumber()
        );
        $this->assertEquals(FileTransferRequest::STATUS_EDIT, $dataObject->getStatus());
    }

    protected function assertLogicalConnection(array $dispatchParams)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('logical_connection');
        $select->where(['logical_connection.id = ?' => 1]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();
        $hydrator = new ClassMethods();
        $prototype = new LogicalConnection();
        /** @var LogicalConnection $dataObject */
        $dataObject = $hydrator->hydrate($data, $prototype);

        $this->assertEquals(
            strtolower($dispatchParams['file_transfer_request']['logical_connection']['type']),
            strtolower($dataObject->getType())
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
        $hydrator = new ClassMethods();
        $prototype = new PhysicalConnectionCd();
        /** @var PhysicalConnectionCd $dataObject */
        $dataObject = $hydrator->hydrate($data, $prototype);

        $this->assertEquals(
            strtolower($dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['type']),
            strtolower($dataObject->getType())
        );
        $this->assertEquals(
            strtolower($dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['role']),
            strtolower($dataObject->getRole())
        );
    }

    protected function assertPhysicalConnectionFtgwEndToMiddle(array $dispatchParams)
    {
        
    }

    protected function assertPhysicalConnectionFtgwMiddleToEnd(array $dispatchParams)
    {
        
    }

    protected function assertEndpointSource(array $dispatchParams)
    {
        
    }

    protected function assertEndpointTarget(array $dispatchParams)
    {
        
    }

    protected function assertEndpointCdAs400Source(array $dispatchParams)
    {
        
    }

    protected function assertEndpointCdAs400Target(array $dispatchParams)
    {
        
    }

}
