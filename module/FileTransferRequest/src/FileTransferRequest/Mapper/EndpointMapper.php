<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\Endpoint;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class EndpointMapper implements EndpointMapperInterface
{

    /**
     *
     * @var AdapterInterface
     */
    protected $dbAdapter;

    /**
     *
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     *
     * @var Endpoint
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Endpoint $prototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     *
     * @param int|string $id
     *
     * @return Endpoint
     * @throws \InvalidArgumentException
     */
    public function find($id)
    {
        /*
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('endpoint_cd_as400');
        $select->where(array(
            'id = ?' => $id
        ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), $this->prototype);
        }

        throw new \InvalidArgumentException("Endpoint with given ID:{$id} not found.");
        */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|Endpoint[]
     */
    public function findAll()
    {
        /*
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('endpoint_cd_as400');

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);

            return $resultSet->initialize($result);
        }

        return array();
        */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @param Endpoint $dataObject
     *
     * @return Endpoint
     * @throws \Exception
     */
    public function save(Endpoint $dataObject)
    {
        $endpointData = $this->hydrator->extract($dataObject);
        unset($endpointData['id']);

        if ($dataObject->getId()) {
            $action = new Update('endpoint_cd_as400');
            $action->set($endpointData);
            $action->where(array(
                'id = ?' => $dataObject->getId()
            ));
        } else {
            $action = new Insert('endpoint_cd_as400');
            $action->values($endpointData);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                $dataObject->setId($newId);
            }

            return $dataObject;
        }

        throw new \Exception('Database error in ' . __METHOD__);
    }
}
