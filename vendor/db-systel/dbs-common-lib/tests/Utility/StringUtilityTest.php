<?php
namespace DbSystel\Tests\Utility;

use PHPUnit\Framework\TestCase;
use DbSystel\Utility\TableDataProcessor;
use DbSystel\Utility\StringUtility;

class StringUtilityTest extends TestCase
{

    private $stringUtility;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->stringUtility = new StringUtility();
    }

    /**
     * @dataProvider provideDataForValidateStringByPrefix
     */
    public function testValidateStringByPrefix($string, $prefix, $expectedResult)
    {
        $this->assertEquals($expectedResult, $this->stringUtility->validateStringByPrefix($string, $prefix));
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
