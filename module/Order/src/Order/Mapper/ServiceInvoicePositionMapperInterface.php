<?php
namespace Order\Mapper;

use DbSystel\DataObject\ServiceInvoicePosition;

interface ServiceInvoicePositionMapperInterface
{

    /**
     *
     * @param int|string $number            
     * @return ServiceInvoicePosition
     * @throws \InvalidArgumentException
     */
    public function find($number);

    /**
     *
     * @return array|ServiceInvoicePosition[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param ServiceInvoicePosition $dataObject            
     * @return ServiceInvoicePosition
     * @throws \Exception
     */
    public function save(ServiceInvoicePosition $dataObject);
}
