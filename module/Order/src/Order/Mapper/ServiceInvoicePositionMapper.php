<?php
namespace Order\Mapper;

use DbSystel\DataObject\ServiceInvoicePosition;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class ServiceInvoicePositionMapper implements ServiceInvoicePositionMapperInterface
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
     * @var ServiceInvoicePosition
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator,
        ServiceInvoicePosition $prototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     *
     * @param int|string $number
     *
     * @return ServiceInvoicePosition
     * @throws \InvalidArgumentException
     */
    public function find($number)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('service_invoice_position');
         * $select->where(array(
         * 'number = ?' => $number
         * ));
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
         * return $this->hydrator->hydrate($result->current(), $this->prototype);
         * }
         *
         * throw new \InvalidArgumentException("ServiceInvoicePosition with given number:{$number} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|ServiceInvoicePosition[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('service_invoice_position');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('number', $condition)) {
                    $select->where(
                        [
                            'number LIKE ?' => '%' . $condition['number'] . '%'
                        ]);
                }
            }
        }

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);

            return $resultSet->initialize($result);
        }

        return [];
    }

    /**
     *
     * @param ServiceInvoicePosition $dataObject
     *
     * @return ServiceInvoicePosition
     * @throws \Exception
     */
    public function save(ServiceInvoicePosition $dataObject)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }
}
