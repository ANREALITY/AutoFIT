<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\PhysicalConnection;

interface PhysicalConnectionMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return PhysicalConnection
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|PhysicalConnection[]
     */
    public function findAll();

    /**
     *
     * @param PhysicalConnection $dataObject
     * @return PhysicalConnection
     * @throws \Exception
     */
    public function save(PhysicalConnection $dataObject);
}
