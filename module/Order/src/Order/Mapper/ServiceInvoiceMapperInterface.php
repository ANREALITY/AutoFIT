<?php
namespace Order\Mapper;

use DbSystel\DataObject\ServiceInvoice;

interface ServiceInvoiceMapperInterface
{

    /**
     *
     * @param int|string $number
     * @return ServiceInvoice
     * @throws \InvalidArgumentException
     */
    public function findOne($number);

    /**
     *
     * @return array|ServiceInvoice[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param ServiceInvoice $dataObject
     * @return ServiceInvoice
     * @throws \Exception
     */
    public function save(ServiceInvoice $dataObject);

}
