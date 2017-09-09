<?php
namespace Test\Integration\Functional\MiscDataOutput;

use DbSystel\DataObject\Article;
use DbSystel\DataObject\LogicalConnection;
use Test\Integration\Functional\AbstractOrderRelatedTest;
use Zend\Http\PhpEnvironment\Response;
use Zend\View\Model\JsonModel;

class MiscDataOutputTest extends AbstractOrderRelatedTest
{

    public function testProvideApplications()
    {
        $technicalShortName = 'comga';
        $getApplicationsUrl = '/order/ajax/provide-applications?'
            . 'data[technical_short_name]=' . $technicalShortName
        ;
        $this->dispatch($getApplicationsUrl, null, [], true);

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Ajax');
        $this->assertControllerClass('AjaxController');
        $this->assertMatchedRouteName('provide-applications');

        /** @var JsonModel $jsonModel */
        $jsonModel = $this->getApplication()->getMvcEvent()->getResult();
        $actualResultsList = $jsonModel->getVariables();
        $expectedResultsList = [
            0 => 'comgate'
        ];
        $this->assertEquals($expectedResultsList, $actualResultsList);
    }

    public function testProvideEnvironments()
    {
        $applicationTechnicalShortName = 'comgate';
        $name = 'ent';
        $getApplicationsUrl = '/order/ajax/provide-environments?'
            . 'data[application_technical_short_name]=' . $applicationTechnicalShortName
            . '&' . 'data[name]=' . $name
        ;
        $this->dispatch($getApplicationsUrl, null, [], true);

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Ajax');
        $this->assertControllerClass('AjaxController');
        $this->assertMatchedRouteName('provide-environments');

        /** @var JsonModel $jsonModel */
        $jsonModel = $this->getApplication()->getMvcEvent()->getResult();
        $actualResultsList = $jsonModel->getVariables();
        $expectedResultsList = [
            0 => [
                'severity' => 5,
                'name' => 'Entwicklung',
                'shortName' => 'E'
            ]
        ];
        $this->assertEquals($expectedResultsList, $actualResultsList);
    }

    /**
     * @param $articleType
     * @param $serviceInvoicePositionNumber
     * @param $expectedResult
     * @dataProvider provideDataForServiceInvoicePositions
     */
    public function testProvideServiceInvoicePositions($articleType, $serviceInvoicePositionNumber, $expectedResult)
    {
        $applicationTechnicalShortName = 'comgate';
        $name = 'ent';
        $getApplicationsUrl = '/order/ajax/provide-service-invoice-positions-' . strtolower($articleType) . '?'
            . 'data[application_technical_short_name]=' . $applicationTechnicalShortName
            . '&' . 'data[connection_type]=' . LogicalConnection::TYPE_CD
            . '&' . 'data[environment_severity]=' . 5
            . '&' . 'data[number]=' . $serviceInvoicePositionNumber
        ;
        $this->dispatch($getApplicationsUrl, null, [], true);

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Ajax');
        $this->assertControllerClass('AjaxController');
        $this->assertMatchedRouteName('provide-service-invoice-positions-' . strtolower($articleType));

        /** @var JsonModel $jsonModel */
        $jsonModel = $this->getApplication()->getMvcEvent()->getResult();
        $actualResultsList = $jsonModel->getVariables();
        $expectedResultsList = [
            0 => $expectedResult
        ];
        $this->assertEquals($expectedResultsList, $actualResultsList);
    }

    public function testProvideServers()
    {
        $name = 'aceip';
        $endpointTypeName = 'CdLinuxUnix';
        $getApplicationsUrl = '/order/ajax/provide-servers?'
            . 'data[name]=' . $name
            . '&' . 'data[endpoint_type_name]=' . $endpointTypeName
        ;
        $this->dispatch($getApplicationsUrl, null, [], true);

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Ajax');
        $this->assertControllerClass('AjaxController');
        $this->assertMatchedRouteName('provide-servers');

        /** @var JsonModel $jsonModel */
        $jsonModel = $this->getApplication()->getMvcEvent()->getResult();
        $actualResultsList = $jsonModel->getVariables();
        $expectedResultsList = [
            'aceip-100v', 'aceip-101v', 'aceip-200v', 'aceip-201v',
        ];
        $this->assertEquals($expectedResultsList, $actualResultsList);
    }

    public function testProvideClusters()
    {
        $virtualNodeName = 'f';
        $getApplicationsUrl = '/order/ajax/provide-clusters?'
            . 'data[virtual_node_name]=' . $virtualNodeName
        ;
        $this->dispatch($getApplicationsUrl, null, [], true);

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Ajax');
        $this->assertControllerClass('AjaxController');
        $this->assertMatchedRouteName('provide-clusters');

        /** @var JsonModel $jsonModel */
        $jsonModel = $this->getApplication()->getMvcEvent()->getResult();
        $actualResultsList = $jsonModel->getVariables();
        $expectedResultsList = [
            [
                'id' => 1,
                'virtualNodeName' => 'foo',
//                'servers' => null, // empty ArrayCollection
//                'endpoints' => null, // empty ArrayCollection
//                'endpoint_cluster_configs' => null, // empty ArrayCollection
            ]
        ];
        $this->assertEquals($expectedResultsList[0]['id'], $actualResultsList[0]['id']);
        $this->assertEquals($expectedResultsList[0]['virtualNodeName'], $actualResultsList[0]['virtualNodeName']);
    }

    public function testProvideServersNotInCdUse()
    {
        $name = 'bnsva';
        $getApplicationsUrl = '/order/ajax/provide-servers-not-in-cd-use?'
            . 'data[name]=' . $name
        ;
        $this->dispatch($getApplicationsUrl, null, [], true);

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Ajax');
        $this->assertControllerClass('AjaxController');
        $this->assertMatchedRouteName('provide-servers-not-in-cd-use');

        /** @var JsonModel $jsonModel */
        $jsonModel = $this->getApplication()->getMvcEvent()->getResult();
        $actualResultsList = $jsonModel->getVariables();
        $expectedResultsList = [
            'abnsva90132', 'abnsva91028'
        ];
        $this->assertEquals($expectedResultsList, $actualResultsList);
    }

    public function testProvideServersNotInCluster()
    {
        $name = 'rerf';
        $getApplicationsUrl = '/order/ajax/provide-servers-not-in-cluster?'
            . 'data[name]=' . $name
        ;
        $this->dispatch($getApplicationsUrl, null, [], true);

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Ajax');
        $this->assertControllerClass('AjaxController');
        $this->assertMatchedRouteName('provide-servers-not-in-cluster');

        /** @var JsonModel $jsonModel */
        $jsonModel = $this->getApplication()->getMvcEvent()->getResult();
        $actualResultsList = $jsonModel->getVariables();
        $expectedResultsList = [
            'ererf210', 'ererf220'
        ];
        $this->assertEquals($expectedResultsList, $actualResultsList);
    }

    public function testProvideUsers()
    {
        $username = 'undefined2';
        $oldUsername = isset($_SERVER['AUTH_USER']) ? $_SERVER['AUTH_USER'] : null;
        if ($username) {
            $_SERVER['AUTH_USER'] = $username;
        }

        $username = 'f';
        $getUsersUrl = '/audit-logging/ajax/provide-users?'
            . 'data[username]=' . $username
        ;
        $this->dispatch($getUsersUrl, null, [], true);

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('AuditLogging');
        $this->assertControllerName('AuditLogging\Controller\Ajax');
        $this->assertControllerClass('AjaxController');
        $this->assertMatchedRouteName('provide-users');

        /** @var JsonModel $jsonModel */
        $jsonModel = $this->getApplication()->getMvcEvent()->getResult();
        $actualResultsList = $jsonModel->getVariables();
        $expectedResultsList = [
            0 => 'undefined',
            1 => 'undefined2',
            2 => 'foo',
            3 => 'foo2',
        ];
        $this->assertEquals($expectedResultsList, $actualResultsList);

        if ($oldUsername) {
            $_SERVER['AUTH_USER'] = $oldUsername;
        } else {
            unset($_SERVER['AUTH_USER']);
        }
    }

    public function testOrders()
    {
        $this->setUpDatabase();
        $this->createOrder('cd', 'cdas400');
        $this->reset();
        $this->createOrder('cd', 'cdtandem');
        $this->reset();
        $this->createOrder('ftgw', 'ftgwcdtandem');
        $this->reset();

        $newUsername = 'undefined2';
        $oldUsername = isset($_SERVER['AUTH_USER']) ? $_SERVER['AUTH_USER'] : null;
        if ($newUsername) {
            $_SERVER['AUTH_USER'] = $newUsername;
        }

        // change_number's are C00000011, C00000013 and C00000022, s. the fixture JSONs
        $changeNumber = '1';
        $getFileTransferRequestsUrl = '/audit-logging/ajax/provide-file-transfer-requests?'
            . 'data[change_number]=' . $changeNumber
        ;
        $this->dispatch($getFileTransferRequestsUrl, null, [], true);

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('AuditLogging');
        $this->assertControllerName('AuditLogging\Controller\Ajax');
        $this->assertControllerClass('AjaxController');
        $this->assertMatchedRouteName('provide-file-transfer-requests');

        /** @var JsonModel $jsonModel */
        $jsonModel = $this->getApplication()->getMvcEvent()->getResult();
        $actualResultsList = $jsonModel->getVariables();

        $expectedResultsList = [
            'C00000011',
            'C00000013'
        ];
        $this->assertEquals($expectedResultsList, $actualResultsList);

        if ($oldUsername) {
            $_SERVER['AUTH_USER'] = $oldUsername;
        } else {
            unset($_SERVER['AUTH_USER']);
        }
    }

    public function provideDataForServiceInvoicePositions()
    {
        return [
            [
                'articleType' => Article::TYPE_BASIC,
                'serviceInvoicePositionNumber' => 'p340',
                'expectedResult' => 'LSP3407738',
            ],
            [
                'articleType' => Article::TYPE_PERSONAL,
                'serviceInvoicePositionNumber' => 'p340',
                'expectedResult' => 'LSP3407744',
            ],
        ];
    }

}
