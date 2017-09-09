<?php
namespace Order\Mapper;

use DbSystel\DataObject\Customer;

interface CustomerMapperInterface
{

    /**
     *
     * @param Customer $dataObject
     * @return Customer
     * @throws \Exception
     */
    public function save(Customer $dataObject);

}
