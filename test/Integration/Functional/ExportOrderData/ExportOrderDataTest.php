<?php
namespace Test\Integration\Functional\ExportOrderData;

use DbSystel\DataExport\DataExporter;
use MasterData\Form\ServerForm;
use Test\Integration\Functional\OrderManipulation\AbstractOrderManipulationTest;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\Request;
use Zend\Http\Response\Stream;
use Zend\Json\Json;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ExportOrderDataTest extends AbstractOrderManipulationTest
{

    public function testExportJson()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $createParams = $this->getCreateParams($connectionType, $endpointSourceType);
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        $orderId = 1;
        $exportOrderUrl = '/export-order/' . $orderId;

        $_SERVER['AUTH_USER'] = 'undefined2';
        $this->dispatch($exportOrderUrl, null, ['format' => DataExporter::EXPORT_FORMAT_JSON]);
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('export-order');


        /** @var Stream $stream */
        $stream = $this->getApplication()->getMvcEvent()->getResult();

        $actualData = $this->getActualData($stream, DataExporter::EXPORT_FORMAT_JSON);

        $this->assertNotNull($stream);
        $this->assertInstanceOf(Stream::class, $stream);
        $this->assertEquals($actualData, $createParams['file_transfer_request']['change_number']);
    }

    public function testExportXml()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $createParams = $this->getCreateParams($connectionType, $endpointSourceType);
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        $orderId = 1;
        $exportOrderUrl = '/export-order/' . $orderId;

        $_SERVER['AUTH_USER'] = 'undefined2';
        $this->dispatch($exportOrderUrl, null, ['format' => DataExporter::EXPORT_FORMAT_XML]);
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('export-order');


        /** @var Stream $stream */
        $stream = $this->getApplication()->getMvcEvent()->getResult();

        $actualData = $this->getActualData($stream, DataExporter::EXPORT_FORMAT_XML);

        $this->assertNotNull($stream);
        $this->assertInstanceOf(Stream::class, $stream);
        $this->assertEquals($actualData, $createParams['file_transfer_request']['change_number']);
    }

    public function testAccessDeniedForNonAdmin()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $createParams = $this->getCreateParams($connectionType, $endpointSourceType);
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        $orderId = 1;
        $exportOrderUrl = '/export-order/' . $orderId;
        $this->dispatch($exportOrderUrl, null, ['format' => DataExporter::EXPORT_FORMAT_JSON]);

        // checking rouintg
        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/error/403');
    }

    protected function getActualData(Stream $stream, string $format)
    {
        return $format === DataExporter::EXPORT_FORMAT_JSON
            ? json_decode($stream->getBody(), true)['change_number']
            : simplexml_load_string($stream->getBody())->change_number
        ;
    }

}
