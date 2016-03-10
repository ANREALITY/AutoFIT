<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\EndpointCdAs400;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class EndpointCdAs400Mapper implements EndpointCdAs400MapperInterface
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
     * @var EndpointCdAs400
     */
    protected $prototype;

    /**
     *
     * @var EndpointMapperInterface
     */
    protected $endpointMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, EndpointCdAs400 $prototype, EndpointMapperInterface $endpointMapper)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
        $this->endpointMapper = $endpointMapper;
    }

    /**
     *
     * @param int|string $id
     *
     * @return EndpointCdAs400
     * @throws \InvalidArgumentException
     */
    public function find($id)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('endpoint_cd_as400');
         * $select->where(array(
         * 'id = ?' => $id
         * ));
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
         * return $this->hydrator->hydrate($result->current(), $this->prototype);
         * }
         *
         * throw new \InvalidArgumentException("EndpointCdAs400 with given ID:{$id} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|EndpointCdAs400[]
     */
    public function findAll()
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('endpoint_cd_as400');
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult()) {
         * $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);
         *
         * return $resultSet->initialize($result);
         * }
         *
         * return array();
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @param EndpointCdAs400 $dataObject
     *
     * @return EndpointCdAs400
     * @throws \Exception
     */
    public function save(EndpointCdAs400 $dataObject)
    {
        $endpoint = $this->endpointMapper->save($dataObject);
        $dataObject->setEndpoint($endpoint);

        $endpointCdAs400Data = $this->hydrator->extract($dataObject);
        $endpointCdAs400Data['endpoint_id'] = $endpoint->getId();

        if ($dataObject->getId()) {
            $action = new Update('endpoint_cd_as400');
            $action->set($endpointCdAs400Data);
            $action->where(array(
                'endpoint_id = ?' => $dataObject->getEndpointId()
            ));
        } else {
            $action = new Insert('endpoint_cd_as400');
            $action->values($endpointCdAs400Data);
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
