<?php
namespace Test\Integration\Functional\MiscDataOutput;

use DbSystel\DataObject\Article;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\Test\AbstractControllerTest;
use Zend\Http\PhpEnvironment\Response;
use Zend\View\Model\JsonModel;

class MiscDataOutputTest extends AbstractControllerTest
{

    public function testGetApplications()
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

    public function testGetEnvironments()
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
                'short_name' => 'E'
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
    public function testServiceInvoicePositions($articleType, $serviceInvoicePositionNumber, $expectedResult)
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

    public function testGetServers()
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

    public function testGetClusters()
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
                'virtual_node_name' => 'foo',
                'servers' => null,
                'endpoints' => null,
                'endpoint_cluster_configs' => null,
            ]
        ];
        $this->assertEquals($expectedResultsList, $actualResultsList);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $reflectionObject = new \ReflectionObject($this);
        foreach ($reflectionObject->getProperties() as $prop) {
            if (!$prop->isStatic() && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }
        unset($_SERVER['AUTH_USER']);
    }

}
