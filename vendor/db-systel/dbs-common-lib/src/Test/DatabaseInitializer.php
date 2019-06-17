<?php
namespace DbSystel\Test;

use PDO;
use Mysqli;
use PHPUnit\DbUnit\Database\DefaultConnection;

/**
 * Class DatabaseInitializer
 *
 * @package DbSystel\Test
 */
class DatabaseInitializer
{

    use DatabaseConnectionTrait;

    /**
     * @var Mysqli
     */
    private $mysqli;
    /**
     * @var string
     */
    private $database;

    public function __construct(array $dbConfigs)
    {
        $this->database = $dbConfigs['database'];
        self::$dbConfigs = $dbConfigs;
    }

    public function setUp()
    {
        $schemaSql = file_get_contents(self::$dbConfigs['scripts']['schema']);
        $storedProceduresSql = file_get_contents(self::$dbConfigs['scripts']['stored-procedures']);
        $basicDataSql = file_get_contents(self::$dbConfigs['scripts']['basic-data']);
        $testDataSqlSet = array_map(function ($sqlFile) {
            return file_get_contents($sqlFile);
        }, self::$dbConfigs['scripts']['test-data']);

        $this->dropDatabase();
        $this->createDatabase();
        $this->useDatabase();
        $this->createSchema($schemaSql);
        $this->createStoredProcedures($storedProceduresSql);
        $this->createBasicData($basicDataSql);
        $this->createTestData($testDataSqlSet);
    }

    public function tearDown()
    {
        self::$pdo = null;
    }

    protected function createDatabase()
    {
        $this->getDatabaseConnection()->exec('CREATE DATABASE IF NOT EXISTS ' . $this->database . ';');
    }

    protected function useDatabase()
    {
        $this->getDatabaseConnection()->exec('USE ' . $this->database . ';');
    }

    protected function createSchema(string $sql)
    {
        $this->getDatabaseConnection()->exec($sql);
    }

    protected function createBasicData(string $sql)
    {
        $this->getDatabaseConnection()->exec($sql);
    }

    protected function createTestData(array $sqlSet = [])
    {
        foreach ($sqlSet as $sql) {
            $this->getDatabaseConnection()->exec($sql);
        }
    }

    protected function createStoredProcedures(string $sql)
    {
        $statement = $this->getDatabaseConnection()->prepare($sql);
        $statement->execute();
    }

    protected function dropDatabase()
    {
        $this->getDatabaseConnection()->exec('DROP DATABASE IF EXISTS ' . $this->database . ';');
    }

    protected function getDatabaseConnection()
    {
        return $this->getConnection()->getConnection();
    }
}
