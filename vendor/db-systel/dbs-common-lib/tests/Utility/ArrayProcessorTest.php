<?php
namespace Utility;

use DbSystel\Utility\ArrayProcessor;

class ArrayProcessorTest extends \PHPUnit_Framework_TestCase
{
    
    const BAR_TYPE_GOOD = 'bar type good';
    const BAR_TYPE_BAD = 'bar type bad';

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

    /**
     * @dataProvider provideDataForValidateArray
     */
    public function testValidateArray($row, $condition, $identifier, $prefix, $expectedResult)
    {
        $this->assertEquals($expectedResult, $this->arrayProcessor->validateArray($row, $condition, $identifier, $prefix));
    }
    
    /**
     * @dataProvider provideDataForValidateArrayExceptions
     */
    public function testValidateArrayExceptions($row, $condition, $identifier, $prefix, $expectedException)
    {
        $this->expectException($expectedException);
        $this->arrayProcessor->validateArray($row, $condition, $identifier, $prefix);
    }
    
    public function provideDataForValidateArray()
    {
        $testRows = [
            0 => [
                // foo data
                'foo__id' => '12',
                'foo__title' => 'foo title 12',
                'foo__bar_id' => '56',
                // bar data
                'bar__id' => '56',
                'bar__name' => 'bar name 56',
                'bar__type' => self::BAR_TYPE_GOOD,
                // buz data
                'buz__id' => '89',
                'buz__desc' => 'buz desc 89',
                'buz__foo_id' => '12',
                null => 'qwer',
            ],
            1 => [
                // foo data
                'foo__id' => '12',
                'foo__title' => 'foo title 12',
                'foo__bar_id' => '56',
                // bar data
                'bar__id' => '56',
                'bar__name' => 'bar name 56',
                'bar__type' => self::BAR_TYPE_GOOD,
                // buz data
                'buz__id' => '89',
                'buz__desc' => 'buz desc 89',
                'buz__foo_id' => '12',
                null => 'qwer',
            ],
            2 => [
                // foo data
                'foo__id' => '13',
                'foo__title' => 'foo title 13',
                'foo__bar_id' => '56',
                // bar data
                'bar__id' => '56',
                'bar__name' => 'bar name 56',
                'bar__type' => self::BAR_TYPE_GOOD,
                // buz data
                'buz__id' => '90',
                'buz__desc' => 'buz desc',
                'buz__foo_id' => '13',
                null => 'qwer',
            ],
            3 => [
                // foo data
                'foo__id' => '13',
                'foo__title' => 'foo title 13',
                'foo__bar_id' => '56',
                // bar data
                'bar__id' => '56',
                'bar__name' => 'bar name 56',
                'bar__type' => self::BAR_TYPE_GOOD,
                // buz data
                'buz__id' => '91',
                'buz__desc' => 'buz desc',
                'buz__foo_id' => '13',
                null => 'qwer',
            ],
            4 => [
                // foo data
                'foo__id' => '14',
                'foo__title' => 'foo title',
                'foo__bar_id' => '57',
                'bar__type' => self::BAR_TYPE_BAD,
                // bar data
                'bar__id' => '57',
                'bar__name' => 'bar name',
                // buz data
                'buz__id' => '91',
                'buz__desc' => 'buz desc',
                'buz__foo_id' => '14',
                null => 'qwer',
            ],
            5 => [
                // foo data
                'foo__id' => '12',
                'foo__title' => 'foo title 12',
                'foo__bar_id' => '56',
                // bar data
                'bar__id' => '56',
                'bar__name' => 'bar name 56',
                'bar__type' => self::BAR_TYPE_GOOD,
                // buz data
                'buz__id' => '89',
                'buz__desc' => 'buz desc 89',
                'buz__foo_id' => '12',
                null => 'qwer',
            ],
            6 => [
                // foo data
                'foo__id' => '12',
                'foo__title' => 'foo title 12',
                'foo__bar_id' => '56',
                // bar data
                'bar__id' => '56',
                'bar__name' => 'bar name 56',
                'bar__type' => self::BAR_TYPE_BAD,
                // buz data
                'buz__id' => '89',
                'buz__desc' => 'buz desc 89',
                'buz__foo_id' => '12',
                null => 'qwer',
            ],
            9 => [
                // foo data
                'foo__id' => '14',
                'foo__title' => 'foo title',
                'foo__bar_id' => '57',
                'bar__type' => self::BAR_TYPE_GOOD,
                // bar data
                'bar__id' => '57',
                'bar__name' => 'bar name',
                // buz data
                'buz__id' => '91',
                'buz__desc' => 'buz desc',
                'buz__foo_id' => '14',
                null => 'qwer',
            ],
        ];
    
        $conditions = [
            0 => null,
            1 => function(array $row) { // correct condition
                $typeIsOk = array_key_exists('bar' . '__' . 'type', $row) && $row['bar' . '__' . 'type'] === self::BAR_TYPE_GOOD;
                return $typeIsOk;
            },
            2 => null,
            3 => null,
            4 => null,
            5 => null,
            6 => function(array $row) { // failing condition
                $typeIsOk = array_key_exists('bar' . '__' . 'type', $row) && $row['bar' . '__' . 'type'] === self::BAR_TYPE_GOOD;
                return $typeIsOk;
            },
            9 => null,
            ];
    
        $identifiers = [
            0 => 'id', // singleIdentifierFoo
            1 => 'id', // 'singleIdentifierBar'
            2 => 'id', // 'singleIdentifierBuz'
            3 => ['id', 'id'], // 'multipleIdentifiers'
            4 => 'missing_identifier', // 'missingIdentifier'
            5 => ['id', 'missing_identifier'], // 'multipleIdentifiers' one is missing
            6 => 'id', // singleIdentifierFoo
            9 => null, // 'nullPrefix'
        ];
    
        $prefixes = [
            0 => 'foo__', // 'singlePrefixFoo'
            1 => 'bar__', // 'singlePrefixBar'
            2 => 'buz__', // 'singlePrefixBuz'
            3 => ['foo__', 'bar__'], // 'multiplePrefixs'
            4 => 'missing_prefix__', // 'missingPrefix'
            5 => ['foo__', 'missing_prefix__'], // 'multiplePrefixs' one is missing
            6 => 'foo__', // 'singlePrefixFoo'
            9 => null, // 'nullIdentifier'
        ];
    
        $expectedResults = [
            0 => true,
            1 => true,
            2 => true,
            3 => true,
            4 => false,
            5 => false,
            6 => false,
            9 => true,
        ];
    
        $data = [];
        foreach ($testRows as $key => $value) {
            $data[] = [
                $testRows[$key],
                $conditions[$key],
                $identifiers[$key],
                $prefixes[$key],
                $expectedResults[$key]
            ];
        }
    
        return $data;
    }
    
    public function provideDataForValidateArrayExceptions()
    {
        $testRows = [
            7 => [
                // foo data
                'foo__id' => '13',
                'foo__title' => 'foo title 13',
                'foo__bar_id' => '56',
                // bar data
                'bar__id' => '56',
                'bar__name' => 'bar name 56',
                'bar__type' => self::BAR_TYPE_GOOD,
                // buz data
                'buz__id' => '90',
                'buz__desc' => 'buz desc',
                'buz__foo_id' => '13',
                null => 'qwer',
            ],
            8 => [
                // foo data
                'foo__id' => '13',
                'foo__title' => 'foo title 13',
                'foo__bar_id' => '56',
                // bar data
                'bar__id' => '56',
                'bar__name' => 'bar name 56',
                'bar__type' => self::BAR_TYPE_BAD,
                // buz data
                'buz__id' => '91',
                'buz__desc' => 'buz desc',
                'buz__foo_id' => '13',
                null => 'qwer',
            ],
        ];
    
        $conditions = [
            7 => null,
            8 => null,
        ];
    
        $identifiers = [
            7 => ['id', 'missing_identifier'], // 'multipleIdentifiers' more than prefixes
            8 => 'id', // singleIdentifierFoo less than prefixes
        ];
    
        $prefixes = [
            7 => 'foo__', // 'singlePrefixFoo' less than identifiers
            8 => ['foo__', 'bar__'], // 'multiplePrefixs' more than identifiers
        ];
    
        $expectedExceptions = [
            7 => \InvalidArgumentException::class,
            8 => \InvalidArgumentException::class,
        ];
    
        $data = [];
        foreach ($testRows as $key => $value) {
            $data[] = [
                $testRows[$key],
                $conditions[$key],
                $identifiers[$key],
                $prefixes[$key],
                $expectedExceptions[$key]
            ];
        }
    
        return $data;
    }

}
