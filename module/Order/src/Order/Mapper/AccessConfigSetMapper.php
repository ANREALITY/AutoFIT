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
