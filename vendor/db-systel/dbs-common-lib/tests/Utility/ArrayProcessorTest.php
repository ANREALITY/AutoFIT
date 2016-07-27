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

    public function testArrayUniqueBySubArray()
    {
        $testArray = [
            0 => [true, false, 123],
            2 => ['foo'],
            4 => [true, false, 123],
            5 => [['foo' => 'bar'], new \stdClass()],
            7 => [4.567, 'abc', null],
            8 => [['foo' => 'bar'], new \AppendIterator()],
            9 => [['foo' => 'bar'], new \Exception()],
        ];
        $implodeSeparator = '|';
        $expectedArray = [
            0 => [true, false, 123],
            2 => ['foo'],
            5 => [['foo' => 'bar'], new \stdClass()],
            7 => [4.567, 'abc', null],
        ];

        $this->assertEquals($expectedArray, $this->arrayProcessor->arrayUniqueBySubArray($testArray, $implodeSeparator));
    }

    public function testStringifySubArrays()
    {
        $testArray = [
            0 => [true, false, 123],
            3 => [4.567, 'abc', null],
            7 => [['foo' => 'bar'], new \stdClass()],
        ];
        $implodeSeparator = '|';
        $expectedArray = [
            0 => '1||123',
            3 => '4.567|abc|',
            7 => 'array|object',
        ];

        $this->assertEquals($expectedArray, $this->arrayProcessor->stringifySubArrays($testArray, $implodeSeparator));
    }

    public function testStringifyArray()
    {
        $testArray = [true, false, 123, 4.567, 'abc', null, ['foo' => 'bar'], new \stdClass()];
        $implodeSeparator = '|';
        $expectedString = '1||123|4.567|abc||array|object';

        $this->assertEquals($expectedString, $this->arrayProcessor->stringifyArray($testArray, $implodeSeparator));
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
