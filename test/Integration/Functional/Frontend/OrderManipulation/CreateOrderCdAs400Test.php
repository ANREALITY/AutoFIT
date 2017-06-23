<?php
namespace Test\Integration\Functional\Frontend\OrderManipulation;

use DbSystel\Test\AbstractIntegrationTest;
use DbSystel\Test\ArrayDataSet;
use PHPUnit\DbUnit\Database\DataSet;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

class CreateOrderCdAs400Test extends AbstractIntegrationTest
{

    /**
     * @test
     */
    public function testSomething()
    {
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
        // $inputArrayObject = new \ArrayObject($inputArray);
        $request->setPost(new Parameters($inputArray));
        $request->setUri('http://autofit.db-systel.work.loc/order/process/edit/195');
        $client = new Client();
        $response = $client->send($request);
        $breakpoint = null;

        $this->markTestSkipped(__METHOD__);
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
