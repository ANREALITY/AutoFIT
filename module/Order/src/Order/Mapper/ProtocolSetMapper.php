<?php
namespace Order\Mapper;

use DbSystel\DataObject\ProtocolSet;
use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Delete;
use DbSystel\DataObject\Protocol;

class ProtocolSetMapper extends AbstractMapper implements ProtocolSetMapperInterface
{

    /**
     *
     * @var ProtocolSet
     */
    protected $prototype;

    /**
     *
     * @var ProtocolMapperInterface
     */
    protected $protocolMapper;

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @param ProtocolMapperInterface $protocolMapper
     */
    public function setProtocolMapper(ProtocolMapperInterface $protocolMapper)
    {
        $this->protocolMapper = $protocolMapper;
    }

    /**
     *
     * @param int|string $id
     *
     * @return ProtocolSet
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|ProtocolSet[]
     */
    public function findAll(array $criteria = [])
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return ProtocolSet
     */
    public function findWithBuldledData($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('protocol_set');
        $select->where([
            'protocol_set.id = ?' => $id
        ]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $return = $this->hydrator->hydrate($result->current(), $this->getPrototype());
            $data = $result->current();

            return $return;
        }

        throw new \InvalidArgumentException("ProtocolSet with given ID:{$id} not found.");
    }

    /**
     *
     * @param ProtocolSet $dataObject
     *
     * @return ProtocolSet
     * @throws \Exception
     */
    public function save(ProtocolSet $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // creating sub-objects
        // data from the recently persisted objects

        if (! $dataObject->getId()) {
            $sql = 'INSERT INTO protocol_set VALUES ();';
        } else {
            $sql = 'UPDATE protocol_set SET id = ' . $dataObject->getId() . ' WHERE id = ' . $dataObject->getId() .';';
        }
        $result = $this->dbAdapter->getDriver()
            ->getConnection()
            ->execute($sql);

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
                // creating sub-objects: in this case only now possible, since the $newId is needed
                $this->protocolMapper->deleteAll(
                    [
                        [
                            'protocol_set_id' => $dataObject->getId()
                        ]
                    ]);
                $newProtocols = [];
                foreach ($dataObject->getProtocols() ?: [] as $protocol) {
                    if ($protocol->getName()) {
                        $protocol->setProtocolSet($dataObject);
                        $newProtocols[] = $this->protocolMapper->save($protocol, false);
                    }
                }
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see ProtocolSetMapperInterface#delete()
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->protocolMapper->deleteAll(
            [
                [
                    'protocol_set_id' => $id
                ]
            ]);

        $action = new Delete('protocol_set');
        $action->where([
            'id = ?' => $id
        ]);
        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
        $return = (bool) $result->getAffectedRows();

        return $return;
    }

    public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null, $identifier = null,
        $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null, callable $dataObjectCondition = null,
        bool $isCollection = false)
    {
        $dataObjects = parent::createDataObjects($resultSetArray, null, null, $identifier, $prefix, $childIdentifier,
            $childPrefix, $prototype, $dataObjectCondition, $isCollection);

        // @todo It's a hack! Find a clean solution!
        if ($prefix === 'endpoint_ftgw_self_service_protocol_set__') {
            $ftgwSelfServiceProtocolDataObjects = $this->protocolMapper->createDataObjects($resultSetArray,
                $identifier, $prefix, 'id', 'endpoint_ftgw_self_service_protocol__', null, null, null, null, true);
        }
        if ($prefix === 'endpoint_ftgw_protocol_server_protocol_set__') {
            $ftgwProtocolServerProtocolDataObjects = $this->protocolMapper->createDataObjects($resultSetArray,
                $identifier, $prefix, 'id', 'endpoint_ftgw_protocol_server_protocol__', null, null, null, null, true);
        }

        foreach ($dataObjects as $key => $dataObject) {
            // DANGEROUS!!!
            // Array key of a common element (created like myArray[] = new Element();)
            // can though equal to the $dataObject->getId()!!!!!
            if ($prefix === 'endpoint_ftgw_self_service_protocol_set__') {
                $this->appendSubDataObject($dataObject, $dataObject->getId(), $ftgwSelfServiceProtocolDataObjects,
                    'setProtocols', 'getId');
            }
            if ($prefix === 'endpoint_ftgw_protocol_server_protocol_set__') {
                $this->appendSubDataObject($dataObject, $dataObject->getId(), $ftgwProtocolServerProtocolDataObjects,
                    'setProtocols', 'getId');
            }
        }

        return $dataObjects;
    }

}
