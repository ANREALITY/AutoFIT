<?php
namespace Base\Test;

use PHPUnit\DbUnit\TestCase;

/**
 * Class AbstractUnitTest
 *
 * @package Base\Test
 */
abstract class AbstractDbTest extends TestCase
{

    use DatabaseConnectionTrait;

}
