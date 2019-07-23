<?php
namespace Tests\UnitTests\UnitTest;

use Base\Test\AbstractDbTest;
use Base\Test\ArrayDataSet;
use PHPUnit\DbUnit\DataSet\IDataSet;

class DummyDbTest extends AbstractDbTest
{

    public function testDummy()
    {
        $this->assertTrue(true);
        $this->assertFalse(false);
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        return new ArrayDataSet([
            'test' => [
                [
                    'foo' => 'foo',
                    'bar' => 'bar'
                ],
            ],
        ]);
    }

}
