<?php
namespace Order\Mapper;

use Base\DataObject\AbstractServiceInvoicePosition;

interface ServiceInvoicePositionMapperInterface
{

    /**
     * @return AbstractServiceInvoicePosition[]
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

}
