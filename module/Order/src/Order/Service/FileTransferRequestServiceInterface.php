<?php
namespace Order\Service;

use DbSystel\DataObject\FileTransferRequest;
use DbSystel\Paginator\Paginator;

interface FileTransferRequestServiceInterface
{

    /**
     *
     * @param int $id
     *            Identifier of the FileTransferRequest that should be returned
     * @return FileTransferRequest
     */
    public function findOne($id);

    /**
     * @param array $criteria
     * @param int $page
     * @param array $sorting
     * @return Paginator
     */
    public function findAll(array $criteria = [], $page = null, array $sorting = []);

    /**
     *
     * @param FileTransferRequest $fileTransferRequest
     * @return FileTransferRequest
     */
    public function saveOne(FileTransferRequest $fileTransferRequestRequest);

    /**
     * @param string|null $changeNumber
     * @return FileTransferRequest[]
     */
    public function findAllForAutocomplete(string $changeNumber = null);

}
