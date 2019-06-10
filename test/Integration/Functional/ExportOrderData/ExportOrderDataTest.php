<?php
namespace Test\Integration\Functional\ExportOrderData;

use DbSystel\DataExport\DataExporter;
use Exception;
use Test\Integration\Functional\AbstractOrderRelatedTest;
use Test\Integration\Functional\OrderManipulation\AbstractOrderManipulationTest;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\Response\Stream;

class ExportOrderDataTest extends AbstractOrderRelatedTest
{

    /**
     * @param string $format
     * @throws Exception
     * @dataProvider provideDataOfFormats
     */
    public function testExportJson(string $format)
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $createParams = $this->getCreateParams($connectionType, $endpointSourceType);
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        $orderId = 1;
        $exportOrderUrl = '/order/export/' . $orderId;

        $_SERVER['AUTH_USER'] = 'undefined2';
        $this->dispatch($exportOrderUrl, null, ['format' => $format]);
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertModuleName('Order');
        $this->assertControllerName('Order\Controller\Process');
        $this->assertControllerClass('ProcessController');
        $this->assertMatchedRouteName('order/export');


        /** @var Stream $stream */
        $stream = $this->getApplication()->getMvcEvent()->getResult();

        $actualData = $this->getActualData($stream, $format);

        $this->assertNotNull($stream);
        $this->assertInstanceOf(Stream::class, $stream);
        $this->assertEquals($actualData, $createParams['file_transfer_request']['change_number']);
    }

    /**
     * @param string $format
     * @throws Exception
     * @dataProvider provideDataOfFormats
     */
    public function testAccessDeniedForNonAdmin(string $format)
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdlinuxunix';
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        $orderId = 1;
        $exportOrderUrl = '/order/export/' . $orderId;
        $this->dispatch($exportOrderUrl, null, ['format' => $format]);

        // checking rouintg
        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/error/403');
    }

    public function provideDataOfFormats()
    {
        return [
            [
                'format' => DataExporter::EXPORT_FORMAT_JSON,
            ],
            [
                'format' => DataExporter::EXPORT_FORMAT_XML,
            ],
        ];
    }

    protected function getActualData(Stream $stream, string $format)
    {
        return $format === DataExporter::EXPORT_FORMAT_JSON
            ? json_decode($stream->getBody(), true)['change_number']
            : simplexml_load_string($stream->getBody())->change_number
        ;
    }

    protected function setUp()
    {
        parent::setUp();
        $this->setUpDatabase();
    }

}
