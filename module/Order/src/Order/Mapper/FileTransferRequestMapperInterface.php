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
    public function findOne($id);

//    /**
//     *
//     * @return array|FileTransferRequest[]
//     */
//    public function findAll(array $criteria = []);

    /**
     *
     * @return array|FileTransferRequest[]
     */
    public function findAllWithBuldledData(array $criteria = [], $id = null, $page = null, $paginationNeeded = true);

    /**
     *
     * @param FileTransferRequest $dataObject
     * @return FileTransferRequest
     * @throws \Exception
     */
    public function save(FileTransferRequest $dataObject);

}
