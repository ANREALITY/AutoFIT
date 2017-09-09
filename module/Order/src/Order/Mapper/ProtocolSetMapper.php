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
     * @var ProtocolMapperInterface
     */
    protected $protocolMapper;

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

}
