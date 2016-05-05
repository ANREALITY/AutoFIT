<?php
namespace Order\Service;

use DbSystel\DataObject\FileTransferRequest;

interface FileTransferRequestServiceInterface
{
    /**
     *
     * @return array|FileTransferRequest[]
     */
    public function findAllWithBuldledData();

    /**
     *
     * @param int $id
     *            Identifier of the FileTransferRequest that should be returned
     * @return FileTransferRequest
     */
    public function findOne($id);

    /**
     *
     * @param FileTransferRequest $fileTransferRequest
     * @return FileTransferRequest
     */
    public function saveOne(FileTransferRequest $fileTransferRequestRequest);

}
