<?php
namespace Utility;

use DbSystel\Utility\ArrayProcessor;

class ArrayProcessorTest extends \PHPUnit_Framework_TestCase
{

    private $arrayProcessor;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->arrayProcessor = new ArrayProcessor('|');
    }

    /**
     * @dataProvider provideDataForArrayUniqueByIdentifier
     */
    public function testArrayUniqueByIdentifier($testArray, $identifier, $expectedArray)
    {
        $this->assertEquals($expectedArray, $this->arrayProcessor->arrayUniqueByIdentifier($testArray, $identifier));
    }

    /**
     * @dataProvider provideDataForRemoveArrayColumns
     */
    public function testRemoveArrayColumns($testArray, $columnNames, $isWhitelist, $expectedArray)
    {
        $this->assertEquals($expectedArray, $this->arrayProcessor->removeArrayColumns($testArray, $columnNames, $isWhitelist));
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
        $expectedArray = [
            0 => [true, false, 123],
            2 => ['foo'],
            5 => [['foo' => 'bar'], new \stdClass()],
            7 => [4.567, 'abc', null],
        ];

        $this->assertEquals($expectedArray, $this->arrayProcessor->arrayUniqueBySubArray($testArray));
    }

    public function testStringifySubArrays()
    {
        $testArray = [
            0 => [true, false, 123],
            3 => [4.567, 'abc', null],
            7 => [['foo' => 'bar'], new \stdClass()],
        ];
        $expectedArray = [
            0 => '1||123',
            3 => '4.567|abc|',
            7 => 'array|object',
        ];

        $this->assertEquals($expectedArray, $this->arrayProcessor->stringifySubArrays($testArray));
    }

    public function testStringifyArray()
    {
        $testArray = [true, false, 123, 4.567, 'abc', null, ['foo' => 'bar'], new \stdClass()];
        $expectedString = '1||123|4.567|abc||array|object';

        $this->assertEquals($expectedString, $this->arrayProcessor->stringifyArray($testArray));
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

    public function provideDataForArrayUniqueByIdentifier()
    {
        $testArray = [
            0   => ['foo' => 'qwer',   'bar' => 'asdf',    'baz' => 'yxcv', 'buz' => 'qxev'],
            'b' => ['foo' => '12',     'bar' => '34',      'baz' => '56', 'buz' => '78'],
            'a' => ['foo' => '12',     'bar' => '34',      'baz' => '56', 'buz' => '78'],
            'c' => ['foo' => '12',     'bar' => '34',      'baz' => '56', 'buz' => '78'],
            3   => ['foo' => '12',     'bar' => '34',      'baz' => '56', 'buz' => '78'],
            5   => ['foo' => 'asdf',   'bar' => '34',      'baz' => '56', 'buz' => '78'],
            6   => ['foo' => '12',     'bar' => 'qw',      'baz' => '56', 'buz' => '78'],
            7   => ['foo' => 'asdf',   'bar' => 'as',      'baz' => '56', 'buz' => '78'],
            8   => ['foo' => '13',     'bar' => 'qw',      'baz' => '56', 'buz' => '78'],
            9   => ['foo' => 'qwer',   'bar' => '34',      'baz' => '56', 'buz' => '78'],
            10  => ['foo' => '12',   'bar' => '34',      'baz' => '56', 'buz' => '78'],
        ];
        $identifiers = [
            'singleIdentifierFoo' => 'foo',
            'singleIdentifierBar' => 'bar',
            'singleIdentifierBuz' => 'buz',
            'multipleIdentifiers' => ['foo', 'bar']
        ];
        $expectedArrays = [
            'singleIdentifierFoo' => [
                0   => ['foo' => 'qwer',   'bar' => 'asdf',    'baz' => 'yxcv', 'buz' => 'qxev'],
                'b' => ['foo' => '12',     'bar' => '34',      'baz' => '56', 'buz' => '78'],
                5   => ['foo' => 'asdf',   'bar' => '34',      'baz' => '56', 'buz' => '78'],
                8   => ['foo' => '13',     'bar' => 'qw',      'baz' => '56', 'buz' => '78'],
            ],
            'singleIdentifierBar' => [
                0   => ['foo' => 'qwer',   'bar' => 'asdf',    'baz' => 'yxcv', 'buz' => 'qxev'],
                'b' => ['foo' => '12',     'bar' => '34',      'baz' => '56', 'buz' => '78'],
                6   => ['foo' => '12',     'bar' => 'qw',      'baz' => '56', 'buz' => '78'],
                7   => ['foo' => 'asdf',   'bar' => 'as',      'baz' => '56', 'buz' => '78'],
            ],
            'multipleIdentifiers' => [
                0   => ['foo' => 'qwer',   'bar' => 'asdf',    'baz' => 'yxcv', 'buz' => 'qxev'],
                'b' => ['foo' => '12',     'bar' => '34',      'baz' => '56', 'buz' => '78'],
                5   => ['foo' => 'asdf',   'bar' => '34',      'baz' => '56', 'buz' => '78'],
                6   => ['foo' => '12',     'bar' => 'qw',      'baz' => '56', 'buz' => '78'],
                7   => ['foo' => 'asdf',   'bar' => 'as',      'baz' => '56', 'buz' => '78'],
                8   => ['foo' => '13',     'bar' => 'qw',      'baz' => '56', 'buz' => '78'],
                9   => ['foo' => 'qwer',   'bar' => '34',      'baz' => '56', 'buz' => '78'],
            ]
        ];
        return [
            // variant without singleIdentifierFoo
            [
                // test array,
                $testArray,
                // identifier
                $identifiers['singleIdentifierFoo'],
                // expected array
                $expectedArrays['singleIdentifierFoo'],
            ],
            // variant with singleIdentifierBar
            [
                // test array,
                $testArray,
                // identifier
                $identifiers['singleIdentifierBar'],
                // expected array
                $expectedArrays['singleIdentifierBar'],
            ],
            // variant with singleIdentifierBar
            [
                // test array,
                $testArray,
                // identifier
                $identifiers['multipleIdentifiers'],
                // expected array
                $expectedArrays['multipleIdentifiers'],
            ],
        ];
    }

    public function provideDataForRemoveArrayColumns()
    {
        $testArray = [
            ['foo' => 'qwer', 'bar' => 'asdf', 'baz' => 'yxcv', 'buz' => 'qxev'],
            ['foo' => '12', 'bar' => '34', 'baz' => '56', 'buz' => '78'],
        ];
        $columns = ['foo', 'baz'];
        $expectedArrays = [
            'forWhitelistFalse' => [
                ['bar' => 'asdf', 'buz' => 'qxev'],
                ['bar' => '34', 'buz' => '78'],
            ],
            'forWhitelistTrue' => [
                ['foo' => 'qwer', 'baz' => 'yxcv'],
                ['foo' => '12', 'baz' => '56'],
            ]
        ];
        return [
            // variant without whitelisting
            [
                // test array,
                $testArray,
                // columns
                $columns,
                false,
                // expected array
                $expectedArrays['forWhitelistFalse'],
            ],
            // variant with whitelisting
            [
                // test array
                $testArray,
                // columns
                $columns,
                true,
                // expected array
                $expectedArrays['forWhitelistTrue'],
            ]
        ];
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
