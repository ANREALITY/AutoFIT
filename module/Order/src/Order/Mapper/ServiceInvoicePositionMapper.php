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

class ServiceInvoicePositionMapper extends AbstractMapper implements ServiceInvoicePositionMapperInterface
{

    /**
     *
     * @var ServiceInvoicePosition
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, 
        ServiceInvoicePosition $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param int|string $number            
     *
     * @return ServiceInvoicePosition
     * @throws \InvalidArgumentException
     */
    public function findOne($number)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('service_invoice_position');
         * $select->where([
         * 'number = ?' => $number
         * ]);
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
         * return $this->hydrator->hydrate($result->current(), $this->getPrototype());
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
                            'service_invoice_position.number LIKE ?' => '%' . $condition['number'] . '%'
                        ]);
                }
                if (array_key_exists('article_type', $condition)) {
                    $select->join('article', 'article.sku = service_invoice_position.article_sku', []);
                    $select->where(
                        [
                            'article.type' => $condition['article_type']
                        ]);
                }
                if (array_key_exists('application_technical_short_name', $condition)) {
                    $select->join(
                        [
                            'service_invoice_for_application' => 'service_invoice'
                        ], 'service_invoice_for_application.number = service_invoice_position.service_invoice_number', 
                        [])->join('application', 
                        'application.technical_short_name = service_invoice_for_application.application_technical_short_name', 
                        []);
                    $select->where(
                        [
                            'application.technical_short_name = ?' => $condition['application_technical_short_name']
                        ]);
                }
                if (array_key_exists('environment_severity', $condition)) {
                    $select->join(
                        [
                            'service_invoice_for_environment' => 'service_invoice'
                        ], 'service_invoice_for_environment.number = service_invoice_position.service_invoice_number', 
                        [])->join('environment', 
                        'environment.severity = service_invoice_for_environment.environment_severity', []);
                    $select->where(
                        [
                            'environment.severity = ?' => $condition['environment_severity']
                        ]);
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
