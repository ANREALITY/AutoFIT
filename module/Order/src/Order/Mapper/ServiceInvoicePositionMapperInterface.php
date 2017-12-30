<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractServiceInvoicePosition;

interface ServiceInvoicePositionMapperInterface
{

    /**
     * @return AbstractServiceInvoicePosition[]
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

}
