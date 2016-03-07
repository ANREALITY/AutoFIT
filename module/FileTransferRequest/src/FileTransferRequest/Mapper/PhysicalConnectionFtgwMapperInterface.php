<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\PhysicalConnectionFtgw;

interface PhysicalConnectionFtgwMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return PhysicalConnectionFtgw
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|PhysicalConnectionFtgw[]
     */
    public function findAll();

    /**
     *
     * @param PhysicalConnectionFtgw $dataObject
     * @return PhysicalConnectionFtgw
     * @throws \Exception
     */
    public function save(PhysicalConnectionFtgw $dataObject);
}
