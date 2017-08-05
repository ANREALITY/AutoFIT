<?php
namespace Test\Integration\Functional\Frontend\OrderManipulation;

use DbSystel\DataObject\FileTransferRequest;
use DbSystel\Test\DatabaseInitializer;
use Order\Form\OrderForm;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Http\Request;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class EditOrderTest extends AbstractHttpControllerTestCase
{

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
    public function testRouteEditOrder()
    {
//        $this->markTestSkipped(__METHOD__);

        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $dispatchCreateUrl = $this->getDispatchUrl($connectionType, $endpointSourceType);
        $dispatchParams = $this->getDispatchParams($connectionType, $endpointSourceType);
        $this->dispatch($dispatchCreateUrl, Request::METHOD_POST, $dispatchParams);

        $this->reset();

        $orderId = 1;
        $dispatchEditUrl = '/order/process/edit/' . $orderId;
        $this->dispatch($dispatchEditUrl);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('edit-order');
        // checking the form
        /** @var OrderForm $orderForm */
        $orderForm = $this->getApplication()->getMvcEvent()->getResult()->getVariable('form', null);
        $this->assertNotNull($orderForm);
        $this->assertInstanceOf(OrderForm::class, $orderForm);
        $this->assertEquals($orderId, $orderForm->get('file_transfer_request')->get('id')->getValue());
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['change_number'],
            $orderForm->get('file_transfer_request')->get('change_number')->getValue()
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['service_invoice_position_basic']['number'],
            $orderForm->get('file_transfer_request')->get('service_invoice_position_basic')->get('number')->getValue()
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['service_invoice_position_personal']['number'],
            $orderForm->get('file_transfer_request')->get('service_invoice_position_personal')->get('number')->getValue()
        );
        $this->assertEquals(
            $dispatchParams['file_transfer_request']['logical_connection']['physical_connection_end_to_end']['endpoint_source']['endpoint_server_config']['server']['name'],
            $orderForm->get('file_transfer_request')->get('logical_connection')->get('physical_connection_end_to_end')->get('endpoint_source')->get('endpoint_server_config')->get('server')->get('name')->getValue()
        );
//        $test = ;
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
