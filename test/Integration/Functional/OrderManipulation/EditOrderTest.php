<?php
namespace Test\Integration\Functional\OrderManipulation;

use DbSystel\DataObject\FileTransferRequest;
use Order\Form\OrderForm;
use Order\Service\UserService;
use Zend\Http\PhpEnvironment\Response;
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
        $createParams = $this->getCreateParams($connectionType, $endpointSourceType);
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        // checking the case "no data -> form with data"
        $orderId = 1;
        $editUrl = '/order/process/edit/' . $orderId;
        $this->dispatch($editUrl);
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('edit-order');

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

        $editParams = $createParams;
        $editParams['file_transfer_request']['id'] = $orderId;
        $editedComment = 'edited comment...';
        $editParams['file_transfer_request']['comment'] = $editedComment;
        $editUrl = '/order/process/edit/' . $orderId;
        $this->dispatch($editUrl, Request::METHOD_POST, $editParams);

        // checking the data saving
        $this->assertEquals(
            $editedComment,
            $this->retrieveActualData('file_transfer_request', 'id', 1)['comment']
        );
    }

    /**
     * Testing, that the order cannot be edited in the improper status.
     */
    public function testPermittingAccessInImproperStatus()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdas400';
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        $orderId = 1;

        $this->changeStatus($orderId, UserService::DEFAULT_MEMBER_USERNAME, 'submit');

        $this->reset();

        // checking the case "no data -> form with data"
        $orderId = 1;
        $editUrl = '/order/process/edit/' . $orderId;
        $this->dispatch($editUrl);
        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo(
            '/order/process/operation-denied-for-status/'
            . 'edit' . '/' . FileTransferRequest::STATUS_PENDING
        );
    }

    /**
     * Testing, that the other user cannot edit the order.
     */
    public function testPermittingAccessForNoCreator()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $createParams = $this->getCreateParams($connectionType, $endpointSourceType);
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        $orderId = 1;

        $_SERVER['AUTH_USER'] = 'undefined2';

        $editParams = $createParams;
        $editParams['file_transfer_request']['id'] = $orderId;
        $originalComment = $editParams['file_transfer_request']['comment'];
        $editedComment = 'new comment...';
        $editParams['file_transfer_request']['comment'] = $editedComment;
        $editUrl = '/order/process/edit/' . $orderId;
        $this->dispatch($editUrl, Request::METHOD_POST, $editParams);

        // checking rouintg
        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/error/403');

        // checking, that the data is not changed
        $this->assertEquals(
            $originalComment,
            $this->retrieveActualData('file_transfer_request', 'id', 1)['comment']
        );
    }

}
