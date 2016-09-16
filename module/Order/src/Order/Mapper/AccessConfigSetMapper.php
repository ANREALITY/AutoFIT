<?php
namespace Order\Mapper;

use DbSystel\DataObject\AccessConfigSet;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Delete;

class AccessConfigSetMapper extends AbstractMapper implements AccessConfigSetMapperInterface
{

    /**
     *
     * @var AccessConfigSet
     */
    protected $prototype;

    /**
     *
     * @var AccessConfigMapperInterface
     */
    protected $accessConfigMapper;

    /**
     *
     * @var type
     */
    protected $type;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, AccessConfigSet $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param AccessConfigMapperInterface $accessConfigMapper
     */
    public function setAccessConfigMapper(AccessConfigMapperInterface $accessConfigMapper)
    {
        $this->accessConfigMapper = $accessConfigMapper;
    }

    /**
     *
     * @param int|string $id
     *
     * @return AccessConfigSet
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|AccessConfigSet[]
     */
    public function findAll(array $criteria = [])
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return AccessConfigSet
     */
    public function findWithBuldledData($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('access_config_set');
        $select->where([
            'access_config_set.id = ?' => $id
        ]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $return = $this->hydrator->hydrate($result->current(), $this->getPrototype());
            $data = $result->current();

            return $return;
        }

        throw new \InvalidArgumentException("AccessConfigSet with given ID:{$id} not found.");
    }

    /**
     *
     * @param AccessConfigSet $dataObject
     *
     * @return AccessConfigSet
     * @throws \Exception
     */
    public function save(AccessConfigSet $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // creating sub-objects
        // data from the recently persisted objects

        if (! $dataObject->getId()) {
            $sql = 'INSERT INTO access_config_set VALUES ();';
        } else {
            $sql = 'UPDATE access_config_set SET id = ' . $dataObject->getId() . ' WHERE id = ' . $dataObject->getId() .';';
        }
        $result = $this->dbAdapter->getDriver()
            ->getConnection()
            ->execute($sql);

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
                // creating sub-objects: in this case only now possible, since the $newId is needed
                $this->accessConfigMapper->deleteAll(
                    [
                        [
                            'access_config_set_id' => $dataObject->getId()
                        ]
                    ]);
                $newAccessConfigs = [];
                foreach ($dataObject->getAccessConfigs() ?: [] as $accessConfig) {
                    if ($accessConfig->getUsername()) {
                        $accessConfig->setAccessConfigSet($dataObject);
                        $newAccessConfigs[] = $this->accessConfigMapper->save($accessConfig, false);
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
     * @see AccessConfigSetMapperInterface#delete()
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->accessConfigMapper->deleteAll(
            [
                [
                    'access_config_set_id' => $id
                ]
            ]);

        $action = new Delete('access_config_set');
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
        if ($prefix === 'endpoint_cd_windows_share_access_config_set__') {
            $cdWindowsShareAccessConfigDataObjects = $this->accessConfigMapper->createDataObjects($resultSetArray,
                $identifier, $prefix, 'id', 'endpoint_cd_windows_share_access_config__', null, null, null, null, true);
        }
        if ($prefix === 'endpoint_ftgw_windows_share_access_config_set__') {
            $ftgwWindowsShareAccessConfigDataObjects = $this->accessConfigMapper->createDataObjects($resultSetArray,
                $identifier, $prefix, 'id', 'endpoint_ftgw_windows_share_access_config__', null, null, null, null, true);
        }

        foreach ($dataObjects as $key => $dataObject) {
            // DANGEROUS!!!
            // Array key of a common element (created like myArray[] = new Element();)
            // can though equal to the $dataObject->getId()!!!!!
            if ($prefix === 'endpoint_cd_windows_share_access_config_set__') {
                $this->appendSubDataObject($dataObject, $dataObject->getId(), $cdWindowsShareAccessConfigDataObjects,
                    'setAccessConfigs', 'getId');
            }
            if ($prefix === 'endpoint_ftgw_windows_share_access_config_set__') {
                $this->appendSubDataObject($dataObject, $dataObject->getId(), $ftgwWindowsShareAccessConfigDataObjects,
                    'setAccessConfigs', 'getId');
            }
        }

        return $dataObjects;
    }

}
