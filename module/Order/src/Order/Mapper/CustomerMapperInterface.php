<?php
namespace Order\Mapper;

use DbSystel\DataObject\Customer;

interface CustomerMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return Customer
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|Customer[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param Customer $dataObject
     * @return Customer
     * @throws \Exception
     */
    public function save(Customer $dataObject);

}
