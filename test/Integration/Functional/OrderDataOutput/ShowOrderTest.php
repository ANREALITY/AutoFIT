<?php
namespace Test\Integration\Functional\OrderDataOutput;

use DbSystel\DataObject\EndpointCdLinuxUnix;
use DbSystel\DataObject\FileTransferRequest;

class ShowOrderTest extends AbstractOrderOutputTest
{

    public function testShowOrder()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $createParams = $this->getCreateParams($connectionType, $endpointSourceType);
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        // testing the accss by the owner
        $orderId = 1;
        $showUrl = '/show-order/' . $orderId;
        $this->dispatch($showUrl);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('show-order');

        /** @var FileTransferRequest $fileTransferRequest */
        $fileTransferRequest = $this->getApplication()->getMvcEvent()->getResult()->getVariable('fileTransferRequest', null);

        $fileTransferRequestData = $createParams['file_transfer_request'];
        $logicalConnectionData = $fileTransferRequestData['logical_connection'];
        $logicalConnection = $fileTransferRequest->getLogicalConnection();
        $physicalConnectionEndToEndData = $logicalConnectionData['physical_connection_end_to_end'];
        $physicalConnectionEndToEnd = $logicalConnection->getPhysicalConnectionEndToEnd();
        $endpointSourceData = $physicalConnectionEndToEndData['endpoint_source'];
        /** @var EndpointCdLinuxUnix $endpointSource */
        $endpointSource = $physicalConnectionEndToEnd->getEndpointSource();

        $this->assertNotNull($fileTransferRequest);
        $this->assertInstanceOf(FileTransferRequest::class, $fileTransferRequest);
        $this->assertEquals($orderId, $fileTransferRequest->getId());
        $this->assertEquals($fileTransferRequestData['change_number'], $fileTransferRequest->getChangeNumber());
        $this->assertEquals(
            $logicalConnectionData['notifications'][0]['email'],
            $logicalConnection->getNotifications()[0]->getEmail()
        );
        $this->assertEquals(
            $fileTransferRequestData['service_invoice_position_basic']['number'],
            $fileTransferRequest->getServiceInvoicePositionBasic()->getNumber()
        );
        $this->assertEquals(
            $fileTransferRequestData['service_invoice_position_personal']['number'],
            $fileTransferRequest->getServiceInvoicePositionPersonal()->getNumber()
        );
        $this->assertEquals(
            $endpointSourceData['endpoint_server_config']['server']['name'],
            $endpointSource->getEndpointServerConfig()->getServer()->getName()
        );
        $this->assertEquals(
            $endpointSourceData['include_parameter_set']['include_parameters'][0]['expression'],
            $endpointSource->getIncludeParameterSet()->getIncludeParameters()[0]->getExpression()
        );

        $this->reset();

        // testing the access by a non-owner
        $_SERVER['AUTH_USER'] = 'undefined2';
        $this->dispatch($showUrl);
        $this->assertResponseStatusCode(200);
        /** @var FileTransferRequest $fileTransferRequestForAnotherUser */
        $fileTransferRequestForAnotherUser = $this->getApplication()->getMvcEvent()->getResult()->getVariable('fileTransferRequest', null);
        $this->assertNotNull($fileTransferRequestForAnotherUser);
        $this->assertInstanceOf(FileTransferRequest::class, $fileTransferRequestForAnotherUser);
        $this->assertEquals($orderId, $fileTransferRequestForAnotherUser->getId());
        $this->assertEquals($fileTransferRequestData['change_number'], $fileTransferRequestForAnotherUser->getChangeNumber());
    }

}
