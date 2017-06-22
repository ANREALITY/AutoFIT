<?php
namespace Order\Mapper;

use DbSystel\DataObject\Application;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Expression;

class ApplicationMapper extends AbstractMapper implements ApplicationMapperInterface
{

    /**
     *
     * @var Application
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Application $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param int|string $technicalShortName
     *
     * @return Application
     * @throws \InvalidArgumentException
     */
    public function findOne($technicalShortName)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|Application[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('application');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('technical_short_name', $condition)) {
                    $select->where(
                        [
                            'application.technical_short_name LIKE ?' => '%' . $condition['technical_short_name'] . '%'
                        ]);
                }
                if (array_key_exists('active', $condition)) {
                    $select->where(
                        [
                            'application.active = ?' => $condition['active']
                        ]);
                }
                if (array_key_exists('with_invoice_positions_only', $condition) && $condition['with_invoice_positions_only'] === true) {
                    $select->join('service_invoice', 'service_invoice.application_technical_short_name = application.technical_short_name');
                    $select->join(['service_invoice_position_basic' => 'service_invoice_position'], new Expression('service_invoice_position_basic.service_invoice_number = service_invoice.number AND service_invoice_position_basic.order_quantity > 0 AND service_invoice_position_basic.status <> "Beendet"'));
                    $select->join(['article_basic' => 'article'], new Expression('service_invoice_position_basic.article_sku = article_basic.sku AND article_basic.type = "basic"'));
                    // If this condition is used sometime again, complete it with product_type_name=cd|fgw for basic.
                    $select->join(['service_invoice_position_personal' => 'service_invoice_position'], new Expression('service_invoice_position_personal.service_invoice_number = service_invoice.number AND service_invoice_position_personal.order_quantity > 0 AND service_invoice_position_personal.status <> "Beendet"'));
                    $select->join(['article_personal' => 'article'], new Expression('service_invoice_position_personal.article_sku = article_personal.sku AND article_personal.type = "personal"'));
                    // If this condition is used sometime again, complete it with product_type_name=cd|fgw for personal.
                }
            }
        }

        $select->group('application.technical_short_name');

        $statement = $sql->prepareStatementForSqlObject($select);

        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->getPrototype());

            return $resultSet->initialize($result);
        }

        return [];
    }

    /**
     *
     * @param Application $dataObject
     *
     * @return Application
     * @throws \Exception
     */
    public function save(Application $dataObject)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

}
