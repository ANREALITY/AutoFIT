<?php
namespace FileTransferRequest\Service;

use DbSystel\DataObject\FileTransferRequest;

interface FileTransferRequestServiceInterface
{

    /**
     * Should return a set of all fileTransferRequestRequest fileTransferRequests that we can iterate over.
     * Single entries of the array are supposed to be
     * implementing FileTransferRequestInterface
     *
     * @return array|FileTransferRequestInterface[]
     */
    public function findAllFileTransferRequests();

    /**
     * Should return a single fileTransferRequestRequest fileTransferRequest
     *
     * @param int $id
     *            Identifier of the FileTransferRequest that should be returned
     * @return FileTransferRequestInterface
     */
    public function findFileTransferRequest($id);

    /**
     * Should save a given implementation of the FileTransferRequestInterface and return it.
     * If it is an existing FileTransferRequest the FileTransferRequest
     * should be updated, if it's a new FileTransferRequest it should be created.
     *
     * @param FileTransferRequestInterface $fileTransferRequest
     * @return FileTransferRequestInterface
     */
    public function saveFileTransferRequest(FileTransferRequest $fileTransferRequestRequest);
}
