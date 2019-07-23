<?php
namespace Test\Integration\Functional\OrderManipulation;

use Base\DataObject\FileTransferRequest;
use Test\Integration\Functional\AbstractOrderRelatedTest;
use Zend\Http\Request;

abstract class AbstractOrderManipulationTest extends AbstractOrderRelatedTest
{

    protected function setUp()
    {
        parent::setUp();
        $this->setUpDatabase();
    }

}