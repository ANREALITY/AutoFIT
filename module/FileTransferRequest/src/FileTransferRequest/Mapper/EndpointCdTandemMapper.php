<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\EndpointCdTandem;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class EndpointCdTandemMapper implements EndpointCdTandemMapperInterface
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
     * @var EndpointCdTandem
     */
    protected $prototype;

    /**
     *
     * @var EndpointMapperInterface
     */
    protected $endpointMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, EndpointCdTandem $prototype, EndpointMapperInterface $endpointMapper)
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
     * @return EndpointCdTandem
     * @throws \InvalidArgumentException
     */
    public function find($id)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('endpoint_cd_tandem');
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
         * throw new \InvalidArgumentException("EndpointCdTandem with given ID:{$id} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|EndpointCdTandem[]
     */
    public function findAll()
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('endpoint_cd_tandem');
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
     * @param EndpointCdTandem $dataObject
     *
     * @return EndpointCdTandem
     * @throws \Exception
     */
    public function save(EndpointCdTandem $dataObject)
    {
        $endpoint = $this->endpointMapper->save($dataObject);
        $dataObject->setEndpoint($endpoint);

        $endpointCdTandemData = $this->hydrator->extract($dataObject);
        $endpointCdTandemData['endpoint_id'] = $endpoint->getId();

        if ($dataObject->getId()) {
            $action = new Update('endpoint_cd_tandem');
            $action->set($endpointCdTandemData);
            $action->where(array(
                'endpoint_id = ?' => $dataObject->getId()
            ));
        } else {
            $action = new Insert('endpoint_cd_tandem');
            $action->values($endpointCdTandemData);
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
