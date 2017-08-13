<?php
namespace DbSystel\Test;

use PDO;
use PHPUnit\DbUnit\Database\DefaultConnection;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class AbstractControllerTest
 *
 * @package DbSystel\Test
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

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->setApplicationConfig(include self::$applicationConfigPath);
        $this->dbAdapter = $this->getApplicationServiceLocator()->get('Zend\Db\Adapter\Adapter');
    }

    /**
     * Creates a new DefaultDatabaseConnection using the given PDO connection
     * and database schema name.
     *
     * @see The original PHPUnit\DbUnit\TestCaseTrait#createDefaultDBConnection(...).
     *
     * @param PDO    $connection
     * @param string $schema
     *
     * @return DefaultConnection
     */
    protected function createDefaultDBConnection(PDO $connection, $schema = '')
    {
        return new DefaultConnection($connection, $schema);
    }

    public static function setApplicationConfigPath(string $applicationConfigPath)
    {
        self::$applicationConfigPath = $applicationConfigPath;
    }

    protected function tearDown()
    {
        parent::tearDown();
        if ($this->dbAdapter && $this->dbAdapter instanceof Adapter) {
            $this->dbAdapter->getDriver()->getConnection()->disconnect();
        }
    }

    protected function retrieveActualData($table, $idColumn, $idValue)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select($table);
        $select->where([$table . '.' . $idColumn . ' = ?' => $idValue]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();
        return $data;
    }

}
