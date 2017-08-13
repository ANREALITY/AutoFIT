<?php
namespace Test\Integration\Functional\OrderDataOutput;

use Test\Integration\Functional\AbstractOrderRelatedTest;

abstract class AbstractOrderOutputTest extends AbstractOrderRelatedTest
{

    protected function setUp()
    {
        parent::setUp();
        $this->setUpDatabase();
    }

}
