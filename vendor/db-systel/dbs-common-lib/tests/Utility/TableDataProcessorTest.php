<?php
namespace Utility;

use DbSystel\Utility\TableDataProcessor;

class TableDataProcessorTest extends \PHPUnit_Framework_TestCase
{
    private $tableDataProcessor;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->tableDataProcessor = new TableDataProcessor('|');
    }

    /**
     * @dataProvider provideDataForTableUniqueByIdentifier
     */
    public function testTableUniqueByIdentifier($testArray, $identifier, $expectedArray)
    {
        $this->assertEquals($expectedArray, $this->tableDataProcessor->tableUniqueByIdentifier($testArray, $identifier));
    }

    /**
     * @dataProvider provideDataForRemoveColumns
     */
    public function testRemoveColumns($testArray, $columnNames, $isWhitelist, $expectedArray)
    {
        $this->assertEquals($expectedArray, $this->tableDataProcessor->removeColumns($testArray, $columnNames, $isWhitelist));
    }

    public function testTableUniqueByRow()
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
    
        $this->assertEquals($expectedArray, $this->tableDataProcessor->tableUniqueByRow($testArray));
    }

    public function testStringifyRows()
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
    
        $this->assertEquals($expectedArray, $this->tableDataProcessor->stringifyRows($testArray));
    }

    public function provideDataForTableUniqueByIdentifier()
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

    public function provideDataForRemoveColumns()
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

}
