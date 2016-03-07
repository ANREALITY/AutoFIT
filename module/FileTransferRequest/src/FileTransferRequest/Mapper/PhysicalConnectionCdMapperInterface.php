<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\PhysicalConnectionCd;

interface PhysicalConnectionCdMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return PhysicalConnectionCd
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|PhysicalConnectionCd[]
     */
    public function findAll();

    /**
     *
     * @param PhysicalConnectionCd $dataObject
     * @return PhysicalConnectionCd
     * @throws \Exception
     */
    public function save(PhysicalConnectionCd $dataObject);
}
