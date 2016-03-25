<?php
namespace Order\Service;

use DbSystel\DataObject\FileTransferRequest;

interface FileTransferRequestServiceInterface
{

    /**
     *
     * @return array|FileTransferRequest[]
     */
    public function findAll();

    /**
     *
     * @param int $id
     *            Identifier of the FileTransferRequest that should be returned
     * @return FileTransferRequest
     */
    public function findFileTransferRequest($id);

    /**
     *
     * @param FileTransferRequest $fileTransferRequest
     * @return FileTransferRequest
     */
    public function saveFileTransferRequest(FileTransferRequest $fileTransferRequestRequest);

}
