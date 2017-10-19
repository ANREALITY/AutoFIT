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
     * @param int|null $limit
     * @param int|null $hydrationMode
     * @return array
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

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
    public function saveDataObject(FileTransferRequest $dataObject);

    /**
     * @param FileTransferRequest $dataObject
     * @return FileTransferRequest
     */
    public function save(FileTransferRequest $dataObject);

}
