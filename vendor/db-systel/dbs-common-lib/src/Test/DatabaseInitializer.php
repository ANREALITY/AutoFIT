<?php
namespace DbSystel\Test;

use PDO;
use Mysqli;

/**
 * Class DatabaseInitializer
 *
 * @package DbSystel\Test
 */
class DatabaseInitializer
{

    /**
     * @var PDO
     */
    private $pdo;
    /**
     * @var Mysqli
     */
    private $mysqli;
    /**
     * @var string
     */
    private $database;
    /**
     * @var array
     */
    private $dbConfigs;

    public function __construct(array $dbConfigs)
    {
        $this->database = $dbConfigs['database'];
        $this->dbConfigs = $dbConfigs;
    }

    public function setUp()
    {
        $schemaSql = file_get_contents($this->dbConfigs['scripts']['schema']);
        $storedProceduresSql = file_get_contents($this->dbConfigs['scripts']['stored-procedures']);
        $basicDataSql = file_get_contents($this->dbConfigs['scripts']['basic-data']);
        $testDataSqlSet = array_map(function ($sqlFile) {
            return file_get_contents($sqlFile);
        }, $this->dbConfigs['scripts']['test-data']);

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
        $this->pdo = null;
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

    protected function getDatabaseConnection() {

        $this->pdo = $this->pdo ?: new PDO(
            $this->dbConfigs['dsn'],
            $this->dbConfigs['username'],
            $this->dbConfigs['password'],
            [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'']
        );

        return $this->pdo;
    }

}
