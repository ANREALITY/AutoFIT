<?php
namespace Test\Integration\Functional\Frontend\OrderManipulation;

use DbSystel\DataObject\AbstractEndpoint;
use DbSystel\DataObject\FileTransferRequest;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\PhysicalConnectionCd;
use DbSystel\Test\AbstractIntegrationTest;
use DbSystel\Test\ArrayDataSet;
use DbSystel\Test\DatabaseInitializer;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Test\Bootstrap;
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

        $this->setUpDatabase();
    }

    /**
     * Testing the controller action basic stuff using the example of cd_cdas400_cdas400.
     */
    public function testRouteCreateOrder()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdas400';
        $dispatchUrl = $this->getDispatchUrl($connectionType, $endpointSourceType);
        $this->dispatch($dispatchUrl);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('create-order');
    }

    /**
     * Testing the basic stuff, that is common for all CD forms, using the example of cd_cdas400_cdas400.
     */
    public function testCommonPropertiesForCd()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdas400';
        $dispatchUrl = $this->getDispatchUrl($connectionType, $endpointSourceType);
        $dispatchParams = $this->getDispatchParams($connectionType, $endpointSourceType);
        $this->dispatch($dispatchUrl, Request::METHOD_POST, $dispatchParams);

        $this->assertFileTransferRequest($dispatchParams);
        $this->assertLogicalConnection($dispatchParams);
        $this->assertPhysicalConnectionCd($dispatchParams);
        $this->assertPhysicalConnectionCdEndToEnd($dispatchParams);
        $this->assertEndpointCdSource($dispatchParams);
        $this->assertEndpointCdTarget($dispatchParams);
    }

    /**
     * Testing the basic stuff, that is common for all FTGW forms, using the example of ftgw_ftgwcdas400_ftgwcdas400.
     */
    public function testCommonPropertiesForFtgw()
    {
        $connectionType = 'ftgw';
        $endpointSourceType = 'ftgwcdas400';
        $dispatchUrl = $this->getDispatchUrl($connectionType, $endpointSourceType);
        $dispatchParams = $this->getDispatchParams($connectionType, $endpointSourceType);
        $this->dispatch($dispatchUrl, Request::METHOD_POST, $dispatchParams);

        $this->assertFileTransferRequest($dispatchParams);
        $this->assertLogicalConnection($dispatchParams);
        $this->assertPhysicalConnectionFtgwEndToMiddle($dispatchParams);
        $this->assertPhysicalConnectionFtgwMiddleToEnd($dispatchParams);
        $this->assertEndpointFtgwSource($dispatchParams);
        $this->assertEndpointFtgwTarget($dispatchParams);
    }

//    public function testSpecificEndpointProperties()
//    {
//        $tests = [
//            'cd'  =>  [
//                'label'  =>  'Cd',
//                'endpoints'  =>  [
//                    ['source' => 'CdAs400', 'target' => 'CdAs400'],
////                    ['source' => 'CdLinuxUnix', 'target' => 'CdLinuxUnix'],
////                    ['source' => 'CdTandem', 'target' => 'CdTandem'],
////                    ['source' => 'CdWindows', 'target' => 'CdWindows'],
////                    ['source' => 'CdWindowsShare', 'target' => 'CdWindowsShare'],
////                    ['source' => 'CdZos', 'target' => 'CdZos'],
//                ],
//            ],
//            'ftgw'  =>  [
//                'label'  =>  'Ftgw',
//                'endpoints'  =>  [
////                    ['source' => 'FtgwCdAs400', 'target' => 'FtgwCdAs400'],
////                    ['source' => 'FtgwCdTandem', 'target' => 'FtgwCdTandem'],
////                    ['source' => 'FtgwCdZos', 'target' => 'FtgwCdZos'],
////                    ['source' => 'FtgwLinuxUnix', 'target' => 'FtgwLinuxUnix'],
////                    ['source' => 'FtgwProtocolServer', 'target' => 'FtgwProtocolServer'],
////                    ['source' => 'FtgwSelfService', 'target' => 'FtgwSelfService'],
////                    ['source' => 'FtgwWindows', 'target' => 'FtgwWindows'],
////                    ['source' => 'FtgwWindowsShare', 'target' => 'FtgwWindowsShare'],
//                ]
//            ],
//        ];
//
//        foreach ($tests as $connectionType => $testsBundle) {
//            foreach ($testsBundle['endpoints'] as $endpointLabel) {
//                $this->assertSpecificEndpointProperties(
//                    $testsBundle['label'], $endpointLabel['source'], $endpointLabel['target']
//                );
//            }
//        }
//    }
//
//    protected function assertSpecificEndpointProperties(
//        $connectionTypeLabel, $endpointSourceTypeLabel, $endpointTargetTypeLabel
//    )
//    {
//        $this->setUpDatabase();
//
//        $connectionType = strtolower($connectionTypeLabel);
//        $endpointTargetTypeLabel = $endpointTargetTypeLabel ?: $endpointSourceTypeLabel;
//        $endpointSourceType = strtolower($endpointSourceTypeLabel);
//        $endpointTargetType = strtolower($endpointTargetTypeLabel);
//
//        $dispatchUrl = $this->getDispatchUrl($connectionType, $endpointSourceType, $endpointTargetType);
//        $dispatchParams = $this->getDispatchParams($connectionType, $endpointSourceType, $endpointTargetType);
//        $this->dispatch($dispatchUrl, Request::METHOD_POST, $dispatchParams);
//
//        $this->{'assertEndpoint' . $endpointSourceTypeLabel . 'Source'}($dispatchParams);
//        $this->{'assertEndpoint' . $endpointTargetTypeLabel . 'Target'}($dispatchParams);
//    }

    public function testCdAs400()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdas400';
        $dispatchUrl = $this->getDispatchUrl($connectionType, $endpointSourceType);
        $dispatchParams = $this->getDispatchParams($connectionType, $endpointSourceType);
        $this->dispatch($dispatchUrl, Request::METHOD_POST, $dispatchParams);

        $this->assertEndpointCdAs400Source($dispatchParams);
        $this->assertEndpointCdAs400Target($dispatchParams);
    }

    public function testCdLinuxUnix()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $dispatchUrl = $this->getDispatchUrl($connectionType, $endpointSourceType);
        $dispatchParams = $this->getDispatchParams($connectionType, $endpointSourceType);
        $this->dispatch($dispatchUrl, Request::METHOD_POST, $dispatchParams);

        $this->assertEndpointCdLinuxUnixSource($dispatchParams);
        $this->assertEndpointCdLinuxUnixTarget($dispatchParams);
    }

    public function testCdTandem()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdtandem';
        $dispatchUrl = $this->getDispatchUrl($connectionType, $endpointSourceType);
        $dispatchParams = $this->getDispatchParams($connectionType, $endpointSourceType);
        $this->dispatch($dispatchUrl, Request::METHOD_POST, $dispatchParams);

        $this->assertEndpointCdTandemSource($dispatchParams);
        $this->assertEndpointCdTandemTarget($dispatchParams);
    }

    public function testCdZos()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdzos';
        $dispatchUrl = $this->getDispatchUrl($connectionType, $endpointSourceType);
        $dispatchParams = $this->getDispatchParams($connectionType, $endpointSourceType);
        $this->dispatch($dispatchUrl, Request::METHOD_POST, $dispatchParams);

        $this->assertEndpointCdZosSource($dispatchParams);
        $this->assertEndpointCdZosTarget($dispatchParams);
    }

    public function testFtgwCdAs400()
    {
        $connectionType = 'ftgw';
        $endpointSourceType = 'ftgwcdas400';
        $dispatchUrl = $this->getDispatchUrl($connectionType, $endpointSourceType);
        $dispatchParams = $this->getDispatchParams($connectionType, $endpointSourceType);
        $this->dispatch($dispatchUrl, Request::METHOD_POST, $dispatchParams);

        $this->assertEndpointFtgwCdAs400Source($dispatchParams);
        $this->assertEndpointFtgwCdAs400Target($dispatchParams);
    }

    protected function assertFileTransferRequest(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('file_transfer_request', 'id', 1);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['change_number'],
            $actualData['change_number']
        );
        $this->assertEquals(FileTransferRequest::STATUS_EDIT, $actualData['status']);
    }

    protected function assertLogicalConnection(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('logical_connection', 'id', 1);

        $this->assertEquals(
            strtolower($dispatchParams['file_transfer_request']['logical_connection']['type']),
            strtolower($actualData['type'])
        );
    }

    protected function assertPhysicalConnectionCd(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('physical_connection', 'id', 1);

        $this->assertEquals(
            strtolower($dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['type']),
            strtolower($actualData['type'])
        );
        $this->assertEquals(
            strtolower($dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['role']),
            strtolower($actualData['role'])
        );
    }

    protected function assertPhysicalConnectionCdEndToEnd(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('physical_connection', 'id', 1);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['secure_plus'],
            $actualData['secure_plus']
        );
    }

    protected function assertPhysicalConnectionFtgwEndToMiddle(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('physical_connection', 'id', 1);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['secure_plus'],
            $actualData['secure_plus']
        );
    }

    protected function assertPhysicalConnectionFtgwMiddleToEnd(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('physical_connection', 'id', 2);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['secure_plus'],
            $actualData['secure_plus']
        );
    }

    protected function assertEndpointCdSource(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint', 'id', 1);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['contact_person'],
            $actualData['contact_person']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['server_place'],
            $actualData['server_place']
        );
    }

    protected function assertEndpointCdTarget(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint', 'id', 2);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['contact_person'],
            $actualData['contact_person']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['server_place'],
            $actualData['server_place']
        );
    }

    protected function assertEndpointFtgwSource(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint', 'id', 1);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['contact_person'],
            $actualData['contact_person']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['server_place'],
            $actualData['server_place']
        );
    }

    protected function assertEndpointFtgwTarget(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint', 'id', 2);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['contact_person'],
            $actualData['contact_person']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['server_place'],
            $actualData['server_place']
        );
    }

    protected function assertEndpointCdAs400Source(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_as400', 'endpoint_id', 1);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointCdAs400Target(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_as400', 'endpoint_id', 2);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointCdLinuxUnixSource(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_linux_unix', 'endpoint_id', 1);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['folder'],
            $actualData['folder']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['transmission_type'],
            $actualData['transmission_type']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['transmission_interval'],
            $actualData['transmission_interval']
        );
    }

    protected function assertEndpointCdLinuxUnixTarget(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_linux_unix', 'endpoint_id', 2);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointCdTandemSource(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_tandem', 'endpoint_id', 1);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointCdTandemTarget(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_tandem', 'endpoint_id', 2);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointCdZosSource(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_zos', 'endpoint_id', 1);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointCdZosTarget(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_zos', 'endpoint_id', 2);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointFtgwCdAs400Source(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_cd_as400', 'endpoint_id', 1);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointFtgwCdAs400Target(array $dispatchParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_cd_as400', 'endpoint_id', 2);

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function getDispatchUrl(string $connectionType, string $endpointSourceType, string $endpointTargetType = null)
    {
        $endpointTargetType = $endpointTargetType ?: $endpointSourceType;
        $dispatchUrl = strtolower(
            '/order/process/create'
            . '/' . $connectionType
            . '/' . $endpointSourceType
            . '/' . $endpointTargetType
        );
        return $dispatchUrl;
    }

    protected function getDispatchParams(string $connectionType, string $endpointSourceType, string $endpointTargetType = null)
    {
        $endpointTargetType = $endpointTargetType ?: $endpointSourceType;
        $fixturesRootFolder = $this->getApplicationServiceLocator()->get('config')['fixtures']['folder'];
        $fixturesFolder = $fixturesRootFolder . '/' . 'order-create-form-data';
        $fixtureFile = $connectionType . '_' . $endpointSourceType . '_' . $endpointTargetType . '.json';
        $fixtureFilePath = $fixturesFolder . '/' . $fixtureFile;
        $fixtureJson = file_get_contents($fixtureFilePath);
        $dispatchParams = json_decode($fixtureJson, true);
        return $dispatchParams;
    }

    protected function retrieveActualData($table, $idColumn, $idValue)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select($table);
        $select->where([$table . '.' . $idColumn . ' = ?' => $idValue]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();
        return $data;
    }

    protected function setUpDatabase()
    {
        /*
         * Complete database setup for every single test.
         * It makes the tests much, much slower.
         * But so we don't need to care about IDs and duplicated entries.
         */
        $dbConfigs = $this->getApplicationServiceLocator()->get('Config')['db'];
        $databaseInitializer = new DatabaseInitializer($dbConfigs);
        $databaseInitializer->setUp();
    }

}
