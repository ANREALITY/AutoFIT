<?php
namespace Test\Integration\Functional\Frontend\OrderManipulation;

use Order\Form\OrderForm;
use Zend\Http\Request;

class EditOrderTest extends AbstractOrderManipulationTest
{

    /**
     * Testing the whole editing process.
     */
    public function testCompleteProcess()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $createUrl = $this->getCreateUrl($connectionType, $endpointSourceType);
        $createParams = $this->getCreateParams($connectionType, $endpointSourceType);
        $this->dispatch($createUrl, Request::METHOD_POST, $createParams);

        $this->reset();

        $orderId = 1;
        $editUrl = '/order/process/edit/' . $orderId;
        $this->dispatch($editUrl);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('edit-order');

        // checking the form
        /** @var OrderForm $orderForm */
        $orderForm = $this->getApplication()->getMvcEvent()->getResult()->getVariable('form', null);

        $fileFransferRequestData = $createParams['file_transfer_request'];
        $fileFransferRequestFieldset = $orderForm->get('file_transfer_request');
        $logicalConnectionData = $fileFransferRequestData['logical_connection'];
        $logicalConnectionFieldset = $fileFransferRequestFieldset->get('logical_connection');
        $physicalConnectionEndToEndData = $logicalConnectionData['physical_connection_end_to_end'];
        $physicalConnectionEndToEndFieldset = $logicalConnectionFieldset->get('physical_connection_end_to_end');
        $endpointSourceData = $physicalConnectionEndToEndData['endpoint_source'];
        $endpointSourceFieldset = $physicalConnectionEndToEndFieldset->get('endpoint_source');

        $this->assertNotNull($orderForm);
        $this->assertInstanceOf(OrderForm::class, $orderForm);
        $this->assertEquals($orderId, $fileFransferRequestFieldset->get('id')->getValue());
        $this->assertEquals(
            $fileFransferRequestData['change_number'],
            $fileFransferRequestFieldset->get('change_number')->getValue()
        );
        $this->assertEquals(
            $logicalConnectionData['notifications'][0]['email'],
            $logicalConnectionFieldset->get('notifications')->get(0)->get('email')->getValue()
        );
        $this->assertEquals(
            $fileFransferRequestData['service_invoice_position_basic']['number'],
            $fileFransferRequestFieldset->get('service_invoice_position_basic')->get('number')->getValue()
        );
        $this->assertEquals(
            $fileFransferRequestData['service_invoice_position_personal']['number'],
            $fileFransferRequestFieldset->get('service_invoice_position_personal')->get('number')->getValue()
        );
        $this->assertEquals(
            $endpointSourceData['endpoint_server_config']['server']['name'],
            $endpointSourceFieldset->get('endpoint_server_config')->get('server')->get('name')->getValue()
        );
        $this->assertEquals(
            $endpointSourceData['include_parameter_set']['include_parameters'][0]['expression'],
            $endpointSourceFieldset->get('include_parameter_set')->get('include_parameters')->get(0)->get('expression')->getValue()
        );

        $this->reset();

        $createParams['file_transfer_request']['id'] = $orderId;
        $newComment = 'new comment...';
        $createParams['file_transfer_request']['comment'] = $newComment;
        $editUrl = '/order/process/edit/' . $orderId;
        $this->dispatch($editUrl, Request::METHOD_POST, $createParams);

        // checking the data saving
        $this->assertEquals(
            $createParams['file_transfer_request']['comment'],
            $this->retrieveActualData('file_transfer_request', 'id', 1)['comment']
        );
    }

}
