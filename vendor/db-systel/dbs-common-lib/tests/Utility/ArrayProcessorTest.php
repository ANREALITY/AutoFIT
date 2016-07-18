<?php
namespace Utility;

use DbSystel\Utility\ArrayProcessor;

class ArrayProcessorTest extends \PHPUnit_Framework_TestCase
{

    private $arrayProcessor;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->arrayProcessor = new ArrayProcessor();
    }

    /**
     * @dataProvider provideDataForRemoveArrayColumns
     */
    public function testRemoveArrayColumns($testArray, $columnNames, $isWhitelist, $expectedArray)
    {
        $this->assertEquals($expectedArray, $this->arrayProcessor->removeArrayColumns($testArray, $columnNames, $isWhitelist));
    }

    public function provideDataForRemoveArrayColumns()
    {
        return [
            // variant without whitelisting
            [
                // test array
                [
                    [
                        'foo' => 'qwer',
                        'bar' => 'asdf',
                        'baz' => 'yxcv',
                        'buz' => 'qxev'
                    ],
                    [
                        'foo' => '12',
                        'bar' => '34',
                        'baz' => '56',
                        'buz' => '78'
                    ],
                ],
                // columns
                ['foo', 'baz'],
                false,
                // expected array
                [
                    [
                        'bar' => 'asdf',
                        'buz' => 'qxev'
                    ],
                    [
                        'bar' => '34',
                        'buz' => '78'
                    ],
                ],
            ],
            // variant with whitelisting
            [
                // test array
                [
                    [
                        'foo' => 'qwer',
                        'bar' => 'asdf',
                        'baz' => 'yxcv',
                        'buz' => 'qxev'
                    ],
                    [
                        'foo' => '12',
                        'bar' => '34',
                        'baz' => '56',
                        'buz' => '78'
                    ],
                ],
                // columns
                ['foo', 'baz'],
                true,
                // expected array
                [
                    [
                        'foo' => 'qwer',
                        'baz' => 'yxcv'
                    ],
                    [
                        'foo' => '12',
                        'baz' => '56'
                    ],
                ],
            ]
        ];
    }

    public function testFlattenArray()
    {
        $testArray = [true, 123, 4.567, 'abc', null, ['foo' => 'bar'], new \stdClass()];
        $expectedArray = [true, 123, 4.567, 'abc', null, 'array', 'object'];

        $this->assertEquals($expectedArray, $this->arrayProcessor->flattenArray($testArray));
    }

    /**
     * @dataProvider provideDataForFlattenVar
     */
    public function testFlattenVar($testValue, $expectedValue)
    {
        $this->assertEquals($expectedValue, $this->arrayProcessor->flattenVar($testValue));
    }

    public function provideDataForFlattenVar()
    {
        return [
            [true, true],
            [123, 123],
            [4.567, 4.567],
            ['abc', 'abc'],
            [null, null],
            [['foo' => 'bar'], 'array'],
            [new \stdClass(), 'object'],
        ];
    }

}
