<?php
namespace Order\Service;

use DbSystel\DataObject\FileTransferRequest;

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
     *
     * @return array|FileTransferRequest[]
     */
    public function findAllWithBuldledData();

    /**
     *
     * @param FileTransferRequest $fileTransferRequest
     * @return FileTransferRequest
     */
    public function saveOne(FileTransferRequest $fileTransferRequestRequest);

}
