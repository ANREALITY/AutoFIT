<?php
namespace Order\Mapper;

use DbSystel\DataObject\ServiceInvoice;
use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class ServiceInvoiceMapper extends AbstractMapper implements ServiceInvoiceMapperInterface
{

    /**
     *
     * @var ServiceInvoice
     */
    protected $prototype;

    /**
     *
     * @var ApplicationMapperInterface
     */
    protected $applicationMapper;

    /**
     *
     * @var EnvironmentMapperInterface
     */
    protected $environmentMapper;

    /**
     * @param \Order\Mapper\ApplicationMapperInterface $applicationMapper
     */
    public function setApplicationMapper($applicationMapper)
    {
        $this->applicationMapper = $applicationMapper;
    }

    /**
     * @param \Order\Mapper\EnvironmentMapperInterface $environmentMapper
     */
    public function setEnvironmentMapper($environmentMapper)
    {
        $this->environmentMapper = $environmentMapper;
    }

    /**
     *
     * @param int|string $number
     *
     * @return ServiceInvoice
     * @throws \InvalidArgumentException
     */
    public function findOne($number)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|ServiceInvoice[]
     */
    public function findAll(array $criteria = [])
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @param ServiceInvoice $dataObject
     *
     * @return ServiceInvoice
     * @throws \Exception
     */
    public function save(ServiceInvoice $dataObject)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null,
        $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
        callable $dataObjectCondition = null, bool $isCollection = false)
    {
        $dataObjects = parent::createDataObjects($resultSetArray, null, null, $identifier, $prefix, $childIdentifier, $childPrefix, $prototype, $dataObjectCondition, $isCollection);

        $applicationDataObjects = $this->applicationMapper->createDataObjects($resultSetArray, null, null,
            'technical_short_name', 'application__', $identifier, $prefix);
        $environmentDataObjects = $this->environmentMapper->createDataObjects($resultSetArray, null, null,
            'severity', 'environment__', $identifier, $prefix);

        foreach ($dataObjects as $key => $dataObject) {
            $this->appendSubDataObject($dataObject, $dataObject->getNumber(), $applicationDataObjects,
                'setApplication', 'getNumber');
            $this->appendSubDataObject($dataObject, $dataObject->getNumber(), $environmentDataObjects,
                'setEnvironment', 'getNumber');
        }

        return $dataObjects;
    }

}
