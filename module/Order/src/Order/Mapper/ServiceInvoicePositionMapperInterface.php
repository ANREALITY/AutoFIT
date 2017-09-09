<?php
namespace Order\Mapper;

use DbSystel\DataObject\ServiceInvoicePosition;

interface ServiceInvoicePositionMapperInterface
{

    /**
     * @return ServiceInvoicePosition[]
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

}
