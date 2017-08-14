<?php
namespace Test\Integration\Functional\AuditLog;

use DbSystel\Test\AbstractControllerTest;
use DbSystel\Test\ArrayDataSet;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\TestCaseTrait;
use Zend\Db\Adapter\Adapter;

class AuditLogOutputTest extends AbstractControllerTest
{

    use TestCaseTrait;

    public function testListLogEntries()
    {
        $this->markTestSkipped();
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        return new ArrayDataSet([
            'test' => [
                [
                    'foo' => 'foo',
                    'bar' => 'bar'
                ],
            ],
        ]);
    }

    protected function tearDown()
    {
        parent::tearDown();

        if ($this->dbAdapter && $this->dbAdapter instanceof Adapter) {
            $this->dbAdapter->getDriver()->getConnection()->disconnect();
        }

        $reflectionObject = new \ReflectionObject($this);
        foreach ($reflectionObject->getProperties() as $prop) {
            if (!$prop->isStatic() && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }

        unset($_SERVER['AUTH_USER']);
    }

}
