<?php
namespace Utility;

use DbSystel\Utility\TableDataProcessor;

class TableDataProcessorTest extends \PHPUnit_Framework_TestCase
{
    
    const BAR_TYPE_GOOD = 'bar type good';
    const BAR_TYPE_BAD = 'bar type bad';

    private $tableDataProcessor;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->tableDataProcessor = new TableDataProcessor('|');
    }

    /**
     * @dataProvider provideDataForValidateRow
     */
    public function testValidateRow($row, $condition, $identifier, $prefix, $expectedResult)
    {
        $this->assertEquals($expectedResult, $this->tableDataProcessor->validateRow($row, $condition, $identifier, $prefix));
    }

    /**
     * @dataProvider provideDataForValidateRowExceptions
     */
    public function testValidateRowExceptions($row, $condition, $identifier, $prefix, $expectedException)
    {
        $this->expectException($expectedException);
        $this->tableDataProcessor->validateRow($row, $condition, $identifier, $prefix);
    }

    /**
     * @dataProvider provideDataForValidateStringByPrefix
     */
    public function testValidateStringByPrefix($string, $prefix, $expectedResult)
    {
        $this->assertEquals($expectedResult, $this->tableDataProcessor->validateStringByPrefix($string, $prefix));
    }

    public function provideDataForValidateRow()
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

    public function provideDataForValidateRowExceptions()
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

    public function provideDataForValidateStringByPrefix()
    {
        $data = [
            [
                'string' => 'foo__qwer',
                'prefix' => 'foo__',
                'expected' => true
            ],
            [
                'string' => 'foo__qwer',
                'prefix' => 'bar__',
                'expected' => false
            ],
            [
                'string' => 'foo__qwer',
                'prefix' => null,
                'expected' => false
            ],
            [
                'string' => 'foo__qwer',
                'prefix' => [
                    'foo__',
                    'bar__'
                ],
                'expected' => true
            ],
            [
                'string' => 'foo__qwer',
                'prefix' => [
                    'bar__',
                    'buz__'
                ],
                'expected' => false
            ],
        ];
        return $data;
    }

}
