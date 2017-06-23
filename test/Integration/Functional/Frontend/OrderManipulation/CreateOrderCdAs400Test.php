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
