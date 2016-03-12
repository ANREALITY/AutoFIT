<?php
namespace Order\Mapper;

use DbSystel\DataObject\FileTransferRequest;

interface FileTransferRequestMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return FileTransferRequest
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|FileTransferRequest[]
     */
    public function findAll();

    /**
     *
     * @param FileTransferRequest $dataObject
     * @return FileTransferRequest
     * @throws \Exception
     */
    public function save(FileTransferRequest $dataObject);
}
