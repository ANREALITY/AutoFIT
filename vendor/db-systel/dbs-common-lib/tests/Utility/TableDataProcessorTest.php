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
     * @dataProvider provideDataForIsProperRow
     */
    public function testIsProperRow($row, $condition, $identifier, $prefix, $expectedResult)
    {
        $this->assertEquals($expectedResult, $this->tableDataProcessor->isProperRow($row, $condition, $identifier, $prefix));
    }

    public function provideDataForIsProperRow()
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
            
        ];

        $identifiers = [
            0 => 'id', // singleIdentifierFoo
            1 => 'id', // 'singleIdentifierBar'
            2 => 'id', // 'singleIdentifierBuz'
            3 => ['id', 'id'], // 'multipleIdentifiers'
            4 => 'missing_identifier', // 'missingIdentifier'
            5 => ['id', 'missing_identifier'], // 'multipleIdentifiers' one is missing
            6 => 'id', // singleIdentifierFoo
        ];

        $prefixes = [
            0 => 'foo__', // 'singlePrefixFoo'
            1 => 'bar__', // 'singlePrefixBar'
            2 => 'buz__', // 'singlePrefixBuz'
            3 => ['foo__', 'bar__'], // 'multiplePrefixs'
            4 => 'missing_prefix__', // 'missingPrefix'
            5 => ['foo__', 'missing_prefix__'], // 'multiplePrefixs' one is missing
            6 => 'foo__', // 'singlePrefixFoo'
        ];

        $expectedResults = [
            true, true, true, true, false, false, false,
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

}
