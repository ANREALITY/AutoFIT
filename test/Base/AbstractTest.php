<?php
namespace Test\Base;

use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\TestCase;

/**
 * Class AbstractTest
 *
 * @package Test\Base
 */
abstract class AbstractTest extends TestCase
{

    /**
     * @var Connection
     */
    private $connection;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        if (! $this->connection) {
            $dbConfigs = (require_once __DIR__ . '/../../config/autoload/test/test.local.php')['db'];
            $database = $dbConfigs['database'];
            $user = $dbConfigs['username'];
            $password = $dbConfigs['password'];
            $dsn = $dbConfigs['dsn'];
            $pdo = new \PDO($dsn, $user, $password);
            $this->connection = $this->createDefaultDBConnection($pdo, $database);
        }
        return $this->connection;
    }

}
