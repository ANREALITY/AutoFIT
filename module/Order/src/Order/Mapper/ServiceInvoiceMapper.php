<?php
namespace Order\Mapper;

use DbSystel\DataObject\ServiceInvoice;
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

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator,
        ServiceInvoice $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
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

//     public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null,
//         $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
//         callable $dataObjectCondition = null, bool $isCollection = false)
//     {
//         $dataObjects = parent::createDataObjects($resultSetArray, null, null, $identifier, $prefix, $childIdentifier, $childPrefix, $prototype, $dataObjectCondition, $isCollection);

//         $serviceInvoiceDataObjects = $this->serviceInvoiceMapper->createDataObjects($resultSetArray, null, null,
//             'number', 'service_invoice_', $identifier, $prefix);

//         foreach ($dataObjects as $key => $dataObject) {
//             // DANGEROUS!!!
//             // Array key of a common element (created like myArray[] = new Element();)
//             // can though quals to the $dataObject->getId()!!!!!
//             $this->appendSubDataObject($dataObject, $dataObject->getId(), $serviceInvoiceDataObjects,
//                 'setServiceInvoice', 'getNumber');
//         }

//         return $dataObjects;
//     }

}
