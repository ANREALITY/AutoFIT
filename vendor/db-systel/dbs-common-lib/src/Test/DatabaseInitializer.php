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

    public function __construct(array $dbConfigs)
    {
        $this->pdo = new PDO(
        'mysql:host=' . $dbConfigs['host'] . ';charset=utf8',
            $dbConfigs['username'],
            $dbConfigs['password']
        );

        $this->mysqli = new Mysqli(
            $dbConfigs['host'],
            $dbConfigs['username'],
            $dbConfigs['password'],
            $dbConfigs['database']
        );
        $this->database = $dbConfigs['database'];
    }

    public function setUp(string $schemaSql, string $storedProceduresSql, string $basicDataSql)
    {
        $this->dropDatabase();
        $this->createDatabase();
        $this->useDatabase();
        $this->createSchema($schemaSql);
        $this->createStoredProcedures($storedProceduresSql);
        $this->createBasicData($basicDataSql);
    }

    public function tearDown()
    {
        // do nothing
    }

    protected function createDatabase()
    {
        $this->pdo->exec('CREATE DATABASE IF NOT EXISTS ' . $this->database . ';');
    }

    protected function useDatabase()
    {
        $this->pdo->exec('USE ' . $this->database . ';');
    }

    protected function createSchema(string $sql)
    {
        $this->pdo->exec($sql);
    }

    protected function createBasicData(string $sql)
    {
        $this->pdo->exec($sql);
    }

    protected function createStoredProcedures(string $sql)
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
    }

    protected function dropDatabase()
    {
        $this->pdo->exec('DROP DATABASE IF EXISTS ' . $this->database . ';');
    }

}