<?php
namespace Test\Base;

use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\TestCase;
use PDO;

/**
 * Class AbstractTest
 *
 * @package Test\Base
 */
abstract class AbstractTest extends TestCase
{

    /**
     * @var array
     */
    static private $dbConfigs;
    /**
     * @var PDO
     */
    static private $pdo;
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
            if (! self::$dbConfigs) {
                self::$dbConfigs = (require_once __DIR__ . '/../../config/autoload/test/test.local.php')['db'];
            }
            if (! self::$pdo) {
                self::$pdo = new PDO(self::$dbConfigs['dsn'], self::$dbConfigs['username'], self::$dbConfigs['password']);
            }
            $this->connection = $this->createDefaultDBConnection(self::$pdo, self::$dbConfigs['database']);
        }
        return $this->connection;
    }

}
