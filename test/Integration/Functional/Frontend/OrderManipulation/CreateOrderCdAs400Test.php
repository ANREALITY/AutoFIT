<?php
namespace Test\Integration\Functional\Frontend\OrderManipulation;

use DbSystel\DataObject\FileTransferRequest;
use DbSystel\Test\AbstractIntegrationTest;
use DbSystel\Test\ArrayDataSet;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Test\Bootstrap;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Http\Request;
use Zend\Hydrator\ClassMethods;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\TreeRouteStack;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\SimpleRouteStack;
use Zend\Stdlib\Parameters;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Uri\Http;

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

        // disabled for now
        /*
        $uri = new Http();
        $uri->setScheme('http');
        $uri->setHost('autofit.db-systel.work.loc');
        $uri->setPath('/order/process/create/cd/cdlinuxunix/cdlinuxunix');

        $request = new Request();
        $request->setMethod(Request::METHOD_POST);
        $inputArray = [
            'file_transfer_request' => [
                'id' => '195',
                'application_technical_short_name' => 'KSP',
                'environment' => [
                    'severity' => '13',
                    'name' => 'Abnahme'
                ],
                'change_number' => 'C10000001'
            ]
        ];
        $request->setUri($uri);
        $request->setPost(new Parameters($inputArray));

        $serviceManager = Bootstrap::getServiceManager();
        $config = $serviceManager->get('config');
        $controllerManager = $serviceManager->get('controllermanager');

        $this->request    = $request;
        $this->routeMatch = new RouteMatch([
            'controller' => 'Order\Controller\Process',
            'action' => 'create',
            'connectionType' => 'cd',
            'endpointSourceType' => 'cdlinuxunix',
            'endpointTargetType' => 'cdlinuxunix'
        ]);
        $this->event      = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $router = TreeRouteStack::factory($config['router']);
        $router->setRequestUri($uri);

        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('request', $request);
        $serviceManager->setService('router', $router);
        $serviceManager->setAllowOverride(false);

        $this->controller = $controllerManager->get('Order\Controller\Process');
        $this->controller->setEvent($this->event);
        */
    }

    public function testCdAs400()
    {

//        $test1 = $this->getRequest();
//        $test2 = $this->getRequest()->getPost()->toArray();
//        $test3 = json_encode($this->getRequest()->getPost()->toArray());
//        $test4 = json_decode($test3, true);

        $dispatchUrl = '/order/process/create/cd/cdas400/cdas400';
        $fixturesRootFolder = $this->getApplicationServiceLocator()->get('config')['fixtures']['folder'];
        $fixturesFolder = $fixturesRootFolder . '/' . 'order-create-form-data';
        $fixtureFile = 'CD_CdAs400_CdAs400.json';
        $fixtureFilePath = $fixturesFolder . '/' . $fixtureFile;
        $fixtureJson = file_get_contents($fixtureFilePath);
        $dispatchParams = json_decode($fixtureJson, true);
        $this->dispatch($dispatchUrl, Request::METHOD_POST, $dispatchParams);

        $this->assertFileTransferRequest($dispatchParams);
    }

    /**
     * @test
     */
    public function testSomething()
    {

//        $this->markTestSkipped(__METHOD__);
        $this->dispatch('/order/process/start-order/cd');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('start-order');

//        $request = $this->getApplication()->getMvcEvent()->getRequest();
//        $response = $this->getApplication()->getMvcEvent()->getResponse();
//        $result = $this->getApplication()->getMvcEvent()->getResult();
//        $breakpoint = null;

//        $test1 = $this->getRequest();
//        $test2 = $this->getRequest()->getPost()->toArray();
//        $test3 = json_encode($this->getRequest()->getPost()->toArray());
//        $test4 = json_decode($test3, true);
//
//        $parameters = new Parameters($test4);
//        $request->setPost($parameters);

//        $request = new Request();
//        $request->setMethod(Request::METHOD_POST);
//
//        $inputArray = [
//            'file_transfer_request' => [
//                'id' => '195',
//                'application_technical_short_name' => 'KSP',
//                'environment' => [
//                    'severity' => '13',
//                    'name' => 'Abnahme'
//                ],
//                'change_number' => 'C10000001'
//            ]
//        ];
//        // $inputArrayObject = new \ArrayObject($inputArray);
//        $request->setPost(new Parameters($inputArray));
//        $request->setUri('http://autofit.db-systel.work.loc/order/process/edit/195');
//        $client = new Client();
//        $response = $client->send($request);
//        $breakpoint = null;
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
        /** @var FileTransferRequest $dataObject */
        $dataObject = $hydrator->hydrate($data, new FileTransferRequest());

        $this->assertEquals(
            $dispatchParams['file_transfer_request']['change_number'],
            $dataObject->getChangeNumber()
        );
        $this->assertEquals(FileTransferRequest::STATUS_EDIT, $dataObject->getStatus());
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        return new ArrayDataSet([]);
    }
}
