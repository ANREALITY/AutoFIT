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

    /**
     * @dataProvider provideMergeArraysElementsToStrings
     */
    public function testMergeArraysElementsToStrings($separator, $placeholder, $array1, $array2, $array3, $expectedResult)
    {
        $this->assertEquals($expectedResult, $this->arrayProcessor->mergeArraysElementsToStrings($separator, $placeholder, $array1, $array2, $array3));
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

    public function provideMergeArraysElementsToStrings()
    {
        $separator = [
            0 => null,
            1 => '~~~'
        ];
        $placeholder = [
            0 => null,
            1 => '###'
        ];
        $arrays = [
            0 => [
                0 => 'prefix_0__',
                1 => 'prefix_1__',
                2 => 'prefix_2__',
                3 => 'prefix_3__',
                4 => 'prefix_4__',
                5 => 'prefix_5__',
                6 => 'prefix_6__',
                7 => 'prefix_7__',
            ],
            1 => [
                0 => 'foo',
                1 => 123,
                2 => 4.567,
                3 => true,
                4 => false,
                5 => null,
                6 => ['x' => 'y'],
                7 => new \stdClass()
            ],
            2 => [
                0 => '__postfix_0',
                1 => '__postfix_1',
                2 => '__postfix_2',
                3 => '__postfix_3',
                4 => '__postfix_4',
                5 => '__postfix_5',
                6 => '__postfix_6',
                7 => '__postfix_7',
            ],
        ];
        $expectedResults = [
            0 => [
                0 => 'prefix_0__|foo|__postfix_0',
                1 => 'prefix_1__|123|__postfix_1',
                2 => 'prefix_2__|4.567|__postfix_2',
                3 => 'prefix_3__|1|__postfix_3',
                4 => 'prefix_4__||__postfix_4',
                5 => 'prefix_5__||__postfix_5',
                6 => 'prefix_6__|array|__postfix_6',
                7 => 'prefix_7__|object|__postfix_7',
            ],
            1 => [
                0 => 'prefix_0__~~~foo~~~__postfix_0',
                1 => 'prefix_1__~~~123~~~__postfix_1',
                2 => 'prefix_2__~~~4.567~~~__postfix_2',
                3 => 'prefix_3__~~~1~~~__postfix_3',
                4 => 'prefix_4__~~~~~~__postfix_4',
                5 => 'prefix_5__~~~###~~~__postfix_5',
                6 => 'prefix_6__~~~array~~~__postfix_6',
                7 => 'prefix_7__~~~object~~~__postfix_7',
            ],
        ];
        $data = [
            [
                $separator[0], $placeholder[0], $arrays[0], $arrays[1], $arrays[2], $expectedResults[0]
            ],
            [
                $separator[1], $placeholder[1], $arrays[0], $arrays[1], $arrays[2], $expectedResults[1]
            ]
        ];
        return $data;
    }

}
