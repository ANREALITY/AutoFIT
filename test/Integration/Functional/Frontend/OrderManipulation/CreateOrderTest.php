<?php
namespace Test\Integration\Functional\Frontend\OrderManipulation;

use DbSystel\DataObject\FileTransferRequest;
use Order\Form\OrderForm;
use Zend\Http\Request;

class CreateOrderTest extends AbstractOrderManipulationTest
{

    /**
     * Testing the controller action basic stuff using the example of cd_cdas400_cdas400.
     */
    public function testRouting()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdas400';
        $createUrl = $this->getCreateUrl($connectionType, $endpointSourceType);
        $this->dispatch($createUrl);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('create-order');
        // checking the form
        /** @var OrderForm $orderForm */
        $orderForm = $this->getApplication()->getMvcEvent()->getResult()->getVariable('form', null);
        $this->assertNotNull($orderForm);
        $this->assertInstanceOf(OrderForm::class, $orderForm);
    }

    /**
     * Testing the basic stuff, that is common for all CD forms, using the example of cd_cdas400_cdas400.
     */
    public function testCommonPropertiesForCd()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdas400';
        $createParams = $this->getCreateParams($connectionType, $endpointSourceType);
        $this->createOrder($connectionType, $endpointSourceType);

        $this->assertFileTransferRequest($createParams);
        $this->assertLogicalConnection($createParams);
        $this->assertPhysicalConnectionCd($createParams);
        $this->assertPhysicalConnectionCdEndToEnd($createParams);
        $this->assertEndpointCdSource($createParams);
        $this->assertEndpointCdTarget($createParams);
    }

    /**
     * Testing the basic stuff, that is common for all FTGW forms, using the example of ftgw_ftgwcdas400_ftgwcdas400.
     */
    public function testCommonPropertiesForFtgw()
    {
        $connectionType = 'ftgw';
        $endpointSourceType = 'ftgwcdas400';
        $createParams = $this->getCreateParams($connectionType, $endpointSourceType);
        $this->createOrder($connectionType, $endpointSourceType);

        $this->assertFileTransferRequest($createParams);
        $this->assertLogicalConnection($createParams);
        $this->assertPhysicalConnectionFtgwEndToMiddle($createParams);
        $this->assertPhysicalConnectionFtgwMiddleToEnd($createParams);
        $this->assertEndpointFtgwSource($createParams);
        $this->assertEndpointFtgwTarget($createParams);
    }

    /**
     * @dataProvider provideDataForSpecificEndpointProperties
     * @param string $connectionTypeLabel
     * @param string $endpointSourceTypeLabel
     * @param string $endpointTargetTypeLabel
     */
    public function testSpecificEndpointProperties(
        $connectionTypeLabel, $endpointSourceTypeLabel, $endpointTargetTypeLabel = null
    )
    {
        $connectionType = strtolower($connectionTypeLabel);
        $endpointTargetTypeLabel = $endpointTargetTypeLabel ?: $endpointSourceTypeLabel;
        $endpointSourceType = strtolower($endpointSourceTypeLabel);
        $endpointTargetType = strtolower($endpointTargetTypeLabel);

        $createParams = $this->getCreateParams($connectionType, $endpointSourceType, $endpointTargetType);
        $this->createOrder($connectionType, $endpointSourceType, $endpointTargetType);

        $this->{'assertEndpoint' . $endpointSourceTypeLabel . 'Source'}($createParams);
        $this->{'assertEndpoint' . $endpointTargetTypeLabel . 'Target'}($createParams);
    }

    protected function assertFileTransferRequest(array $createParams)
    {
        $actualData = $this->retrieveActualData('file_transfer_request', 'id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['change_number'],
            $actualData['change_number']
        );
        $this->assertEquals(FileTransferRequest::STATUS_EDIT, $actualData['status']);
    }

    protected function assertLogicalConnection(array $createParams)
    {
        $actualData = $this->retrieveActualData('logical_connection', 'id', 1);

        $this->assertEquals(
            strtolower($createParams['file_transfer_request']['logical_connection']['type']),
            strtolower($actualData['type'])
        );
    }

    protected function assertPhysicalConnectionCd(array $createParams)
    {
        $actualData = $this->retrieveActualData('physical_connection', 'id', 1);

        $this->assertEquals(
            strtolower($createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['type']),
            strtolower($actualData['type'])
        );
        $this->assertEquals(
            strtolower($createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['role']),
            strtolower($actualData['role'])
        );
    }

    protected function assertPhysicalConnectionCdEndToEnd(array $createParams)
    {
        $actualData = $this->retrieveActualData('physical_connection', 'id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['secure_plus'],
            $actualData['secure_plus']
        );
    }

    protected function assertPhysicalConnectionFtgwEndToMiddle(array $createParams)
    {
        $actualData = $this->retrieveActualData('physical_connection', 'id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['secure_plus'],
            $actualData['secure_plus']
        );
    }

    protected function assertPhysicalConnectionFtgwMiddleToEnd(array $createParams)
    {
        $actualData = $this->retrieveActualData('physical_connection', 'id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['secure_plus'],
            $actualData['secure_plus']
        );
    }

    protected function assertEndpointCdSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint', 'id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['contact_person'],
            $actualData['contact_person']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['server_place'],
            $actualData['server_place']
        );
    }

    protected function assertEndpointCdTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint', 'id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['contact_person'],
            $actualData['contact_person']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['server_place'],
            $actualData['server_place']
        );
    }

    protected function assertEndpointFtgwSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint', 'id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['contact_person'],
            $actualData['contact_person']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['server_place'],
            $actualData['server_place']
        );
    }

    protected function assertEndpointFtgwTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint', 'id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['contact_person'],
            $actualData['contact_person']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['server_place'],
            $actualData['server_place']
        );
    }

    protected function assertEndpointCdAs400Source(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_as400', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointCdAs400Target(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_as400', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointCdLinuxUnixSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_linux_unix', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['folder'],
            $actualData['folder']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['transmission_type'],
            $actualData['transmission_type']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['transmission_interval'],
            $actualData['transmission_interval']
        );
    }

    protected function assertEndpointCdLinuxUnixTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_linux_unix', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointCdTandemSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_tandem', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointCdTandemTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_tandem', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointCdWindowsSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_windows', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['folder'],
            $actualData['folder']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['transmission_type'],
            $actualData['transmission_type']
        );
    }

    protected function assertEndpointCdWindowsTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_windows', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointCdWindowsShareSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_windows_share', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['sharename'],
            $actualData['sharename']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['folder'],
            $actualData['folder']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['transmission_type'],
            $actualData['transmission_type']
        );
    }

    protected function assertEndpointCdWindowsShareTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_windows_share', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['sharename'],
            $actualData['sharename']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointCdZosSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_zos', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointCdZosTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_cd_zos', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointFtgwCdAs400Source(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_cd_as400', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointFtgwCdAs400Target(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_cd_as400', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointFtgwCdTandemSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_cd_tandem', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointFtgwCdTandemTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_cd_tandem', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointFtgwCdZosSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_cd_zos', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointFtgwCdZosTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_cd_zos', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
    }

    protected function assertEndpointFtgwLinuxUnixSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_linux_unix', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['folder'],
            $actualData['folder']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['transmission_type'],
            $actualData['transmission_type']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['transmission_interval'],
            $actualData['transmission_interval']
        );
    }

    protected function assertEndpointFtgwLinuxUnixTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_linux_unix', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointFtgwProtocolServerSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_protocol_server', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['folder'],
            $actualData['folder']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['dns_address'],
            $actualData['dns_address']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['ip'],
            $actualData['ip']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['port'],
            $actualData['port']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['transmission_type'],
            $actualData['transmission_type']
        );
    }

    protected function assertEndpointFtgwProtocolServerTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_protocol_server', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['username'],
            $actualData['username']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['dns_address'],
            $actualData['dns_address']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['ip'],
            $actualData['ip']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['port'],
            $actualData['port']
        );
    }

    protected function assertEndpointFtgwSelfServiceSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_self_service', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['connection_type'],
            $actualData['connection_type']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['ftgw_username'],
            $actualData['ftgw_username']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['mailbox'],
            $actualData['mailbox']
        );
    }

    protected function assertEndpointFtgwSelfServiceTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_self_service', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['connection_type'],
            $actualData['connection_type']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['ftgw_username'],
            $actualData['ftgw_username']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['mailbox'],
            $actualData['mailbox']
        );
    }

    protected function assertEndpointFtgwWindowsSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_windows', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointFtgwWindowsTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_windows', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointFtgwWindowsShareSource(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_windows_share', 'endpoint_id', 1);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['sharename'],
            $actualData['sharename']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_end_to_middle']['endpoint_source']['folder'],
            $actualData['folder']
        );
    }

    protected function assertEndpointFtgwWindowsShareTarget(array $createParams)
    {
        $actualData = $this->retrieveActualData('endpoint_ftgw_windows_share', 'endpoint_id', 2);

        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['sharename'],
            $actualData['sharename']
        );
        $this->assertEquals(
            $createParams['file_transfer_request']['logical_connection']['physical_connection_middle_to_end']['endpoint_target']['folder'],
            $actualData['folder']
        );
    }

    public function provideDataForSpecificEndpointProperties()
    {
        return [
            [
                'connectionTypeLabel' => 'Cd',
                'endpointSourceTypeLabel' => 'CdAs400',
            ],
            [
                'connectionTypeLabel' => 'Cd',
                'endpointSourceTypeLabel' => 'CdLinuxUnix',
            ],
            [
                'connectionTypeLabel' => 'Cd',
                'endpointSourceTypeLabel' => 'CdTandem',
            ],
            [
                'connectionTypeLabel' => 'Cd',
                'endpointSourceTypeLabel' => 'CdWindows',
            ],
            [
                'connectionTypeLabel' => 'Cd',
                'endpointSourceTypeLabel' => 'CdWindowsShare',
            ],
            [
                'connectionTypeLabel' => 'Cd',
                'endpointSourceTypeLabel' => 'CdZos',
            ],
            [
                'connectionTypeLabel' => 'Ftgw',
                'endpointSourceTypeLabel' => 'FtgwCdAs400',
            ],
            [
                'connectionTypeLabel' => 'Ftgw',
                'endpointSourceTypeLabel' => 'FtgwCdTandem',
            ],
            [
                'connectionTypeLabel' => 'Ftgw',
                'endpointSourceTypeLabel' => 'FtgwCdZos',
            ],
            [
                'connectionTypeLabel' => 'Ftgw',
                'endpointSourceTypeLabel' => 'FtgwLinuxUnix',
            ],
            [
                'connectionTypeLabel' => 'Ftgw',
                'endpointSourceTypeLabel' => 'FtgwProtocolServer',
            ],
            [
                'connectionTypeLabel' => 'Ftgw',
                'endpointSourceTypeLabel' => 'FtgwSelfService',
            ],
            [
                'connectionTypeLabel' => 'Ftgw',
                'endpointSourceTypeLabel' => 'FtgwWindows',
            ],
            [
                'connectionTypeLabel' => 'Ftgw',
                'endpointSourceTypeLabel' => 'FtgwWindowsShare',
            ],
        ];
    }

}
