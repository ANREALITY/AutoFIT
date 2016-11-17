<?php
namespace Order\Mapper;

use DbSystel\DataObject\Environment;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class EnvironmentMapper extends AbstractMapper implements EnvironmentMapperInterface
{

    /**
     *
     * @var Environment
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Environment $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param int|string $severity
     *
     * @return Environment
     * @throws \InvalidArgumentException
     */
    public function findOne($severity)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|Environment[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('environment');
        $select->quantifier(Select::QUANTIFIER_DISTINCT);

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (! empty($condition['name'])) {
                    $select->where(
                        [
                            'name LIKE ?' => '%' . $condition['name'] . '%'
                        ]);
                }
                if (! empty($condition['application_technical_short_name'])) {
                    $select->join('service_invoice', 'service_invoice.environment_severity = environment.severity');
                    $select->join('application',
                        'application.technical_short_name = service_invoice.application_technical_short_name', []);
                    $select->where(
                        [
                            'application.technical_short_name = ?' => $condition['application_technical_short_name']
                        ]);
                }
                if (array_key_exists('with_invoice_positions_only', $condition) && $condition['with_invoice_positions_only'] === true) {
                    $select->join(['service_invoice_position_basic' => 'service_invoice_position'], new Expression('service_invoice_position_basic.service_invoice_number = service_invoice.number AND service_invoice_position_basic.order_quantity > 0 AND service_invoice_position_basic.status <> "Beendet"'));
                    $select->join(['article_basic' => 'article'], new Expression('service_invoice_position_basic.article_sku = article_basic.sku AND article_basic.type = "basic"'));
                    $select->join(['service_invoice_position_personal' => 'service_invoice_position'], new Expression('service_invoice_position_personal.service_invoice_number = service_invoice.number AND service_invoice_position_personal.order_quantity > 0 AND service_invoice_position_personal.status <> "Beendet"'));
                    $select->join(['article_personal' => 'article'], new Expression('service_invoice_position_personal.article_sku = article_personal.sku AND article_personal.type = "personal"'));
                }
            }
        }

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
     * @param Environment $dataObject
     *
     * @return Environment
     * @throws \Exception
     */
    public function save(Environment $dataObject)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

}
