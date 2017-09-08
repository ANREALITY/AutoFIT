<?php
namespace Order\Mapper;

use DbSystel\DataObject\FileTransferRequest;
use DbSystel\Paginator\Paginator;

interface FileTransferRequestMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return FileTransferRequest
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     * @param array $criteria
     * @param int $page
     * @return Paginator
     */
    public function findAllPaginated(array $criteria = [], $page = null);

    /**
     *
     * @param FileTransferRequest $dataObject
     * @return FileTransferRequest
     * @throws \Exception
     */
    public function save(FileTransferRequest $dataObject);

}
