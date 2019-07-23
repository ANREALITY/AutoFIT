<?php
namespace Order\Mapper;

use Base\DataObject\FileTransferRequest;
use Base\Paginator\Paginator;

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
     * @param array $sorting
     * @return Paginator
     */
    public function findAllPaginated(array $criteria = [], $page = null, array $sorting = []);

    /**
     * @param FileTransferRequest $dataObject
     * @return FileTransferRequest
     */
    public function save(FileTransferRequest $dataObject);

}
