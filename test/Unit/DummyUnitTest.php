<?php
namespace Tests\UnitTests\UnitTest;

use Base\Test\AbstractUnitTest;

class DummyUnitTest extends AbstractUnitTest
{

    public function testDummy()
    {
        $this->assertTrue(true);
        $this->assertFalse(false);
    }

}
