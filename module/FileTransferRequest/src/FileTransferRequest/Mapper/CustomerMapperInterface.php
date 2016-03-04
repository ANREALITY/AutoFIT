<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\Customer;
use DbSystel\Mapper\MapperInterface;

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
    public function findAll();

    /**
     *
     * @param Customer $dataObject            
     * @return Customer
     * @throws \Exception
     */
    public function save(Customer $dataObject);
}
