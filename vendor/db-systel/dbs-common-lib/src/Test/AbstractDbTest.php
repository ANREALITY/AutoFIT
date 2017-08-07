<?php
namespace DbSystel\Test;

use PHPUnit\DbUnit\TestCase;

/**
 * Class AbstractUnitTest
 *
 * @package DbSystel\Test
 */
abstract class AbstractDbTest extends TestCase
{

    use DatabaseConnectionTrait;

}
