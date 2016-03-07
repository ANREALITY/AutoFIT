<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\LogicalConnection;

interface LogicalConnectionMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return LogicalConnection
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|LogicalConnection[]
     */
    public function findAll();

    /**
     *
     * @param LogicalConnection $dataObject
     * @return LogicalConnection
     * @throws \Exception
     */
    public function save(LogicalConnection $dataObject);
}
