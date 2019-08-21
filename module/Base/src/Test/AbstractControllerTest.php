<?php
namespace Base\Test;

use Doctrine\ORM\EntityManager;
use PDO;
use PHPUnit\DbUnit\Database\DefaultConnection;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class AbstractControllerTest
 *
 * @package Base\Test
 */
abstract class AbstractControllerTest extends AbstractHttpControllerTestCase
{

    use DatabaseConnectionTrait;

    /**
     * @var string
     */
    static private $applicationConfigPath;

    /** @var Adapter */
    protected $dbAdapter;

    /** @var EntityManager */
    protected $entityManager;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->setApplicationConfig(include self::$applicationConfigPath);
        $this->dbAdapter = $this->getApplicationServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $this->entityManager = $this->getApplicationServiceLocator()->get('doctrine.entitymanager.orm_default');
    }

    public static function setApplicationConfigPath(string $applicationConfigPath)
    {
        self::$applicationConfigPath = $applicationConfigPath;
    }

    protected function tearDown()
    {
        // Connections: 354
        // Time: 5.7 minutes, Memory: 622.00MB
        // OK (102 tests, 367 assertions)
        // no optimization

        // Connections: 326 (26 connections less)
        // Time: 5.86 minutes, Memory: 620.00MB
        // OK (102 tests, 367 assertions)
        // if ($this->dbAdapter && $this->dbAdapter instanceof Adapter) {
        //     $this->dbAdapter->getDriver()->getConnection()->disconnect();
        // }

        // Connections: 354
        // Time: 5.67 minutes, Memory: 620.00MB
        // OK (102 tests, 367 assertions)
        // $this->entityManager->close();

        // Connections: 291 (63 connections less)
        // Time: 5.63 minutes, Memory: 622.00MB
        // OK (102 tests, 367 assertions)
        // $this->entityManager->getConnection()->close();

        // Connections: 264 (90 connections less)
        // Time: 5.7 minutes, Memory: 620.00MB
        // OK (102 tests, 367 assertions)
        // if ($this->dbAdapter && $this->dbAdapter instanceof Adapter) {
        //     $this->dbAdapter->getDriver()->getConnection()->disconnect();
        // }
        // $this->entityManager->getConnection()->close();

        $reflectionObject = new \ReflectionObject($this);
        foreach ($reflectionObject->getProperties() as $prop) {
            if (!$prop->isStatic() && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }

        $this->reset();
        $this->application = null;
        gc_collect_cycles();

        unset($_SERVER['AUTH_USER']);

        parent::tearDown();
    }

    protected function retrieveActualData($table, $idColumn, $idValue)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select($table);
        $select->where([$table . '.' . $idColumn . ' = ?' => $idValue]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();
        // Decreases the total number of the connections by 1 less.
        // $this->dbAdapter->getDriver()->getConnection()->disconnect();
        return $data;
    }

}
