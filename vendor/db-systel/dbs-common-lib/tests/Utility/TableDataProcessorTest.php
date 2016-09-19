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

}
