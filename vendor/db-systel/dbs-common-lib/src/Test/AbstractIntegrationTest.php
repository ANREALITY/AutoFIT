<?php
namespace DbSystel\Test;

use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\InvalidArgumentException;
use PHPUnit\DbUnit\TestCase;
use PDO;

/**
 * Class AbstractUnitTest
 *
 * @package DbSystel\Test
 */
abstract class AbstractIntegrationTest extends TestCase
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
                throw new InvalidArgumentException(
                    'Set the database configuration first.'
                    . ' '. 'Use the ' . self::class . '::setDbConfigs(...).'
                );
            }
            if (! self::$pdo) {
                self::$pdo = new PDO(self::$dbConfigs['dsn'], self::$dbConfigs['username'], self::$dbConfigs['password']);
            }
            $this->connection = $this->createDefaultDBConnection(self::$pdo, self::$dbConfigs['database']);
        }
        return $this->connection;
    }

    public static function setDbConfigs(array $dbConfigs)
    {
        self::$dbConfigs = $dbConfigs;
    }

}
