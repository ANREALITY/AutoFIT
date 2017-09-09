<?php
namespace Order\Mapper;

use DbSystel\DataObject\AccessConfigSet;
use Doctrine\ORM\EntityManager;
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
     * @var AccessConfigMapperInterface
     */
    protected $accessConfigMapper;

    /**
     *
     * @var string
     */
    protected $type;

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

}
