<?php
namespace DbSystel\Test;

use PDO;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Database\DefaultConnection;
use PHPUnit\DbUnit\InvalidArgumentException;

trait DatabaseConnectionTrait
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
                self::$pdo = new PDO(
                    self::$dbConfigs['dsn'],
                    self::$dbConfigs['username'],
                    self::$dbConfigs['password'],
                    [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'']
                );
            }
            $this->connection = $this->createDefaultDBConnection(self::$pdo, self::$dbConfigs['database']);
        }
        return $this->connection;
    }

    public static function setDbConfigs(array $dbConfigs)
    {
        self::$dbConfigs = $dbConfigs;
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

}
