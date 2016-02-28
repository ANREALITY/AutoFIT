<?php
namespace DbSystel\Hydrator;

use Zend\Hydrator\ClassMethods;

abstract class AbstractHydratorTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var ClassMethods
     */
    private $hydrator;

    /**
     *
     * @return the $hydrator
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     *
     * @param \DbSystel\Hydrator\ClassMethods $hydrator            
     */
    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->setHydrator($this->createHydrator());
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->hydrator = null;
        parent::tearDown();
    }

    abstract protected function createHydrator();

    abstract protected function createFixtureObject();

    abstract protected function createFixtureArray();
}
