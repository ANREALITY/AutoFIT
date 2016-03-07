<?php
namespace FileTransferRequest\Service;

use FileTransferRequest\Mapper\FileTransferRequestMapperInterface;
use DbSystel\DataObject\FileTransferRequest;

class FileTransferRequestService implements FileTransferRequestServiceInterface
{

    /**
     *
     * @var \FileTransferRequest\Mapper\FileTransferRequestMapperInterface
     */
    protected $fileTransferRequestMapper;

    /**
     *
     * @param FileTransferRequestMapperInterface $fileTransferRequestMapper
     */
    public function __construct(FileTransferRequestMapperInterface $fileTransferRequestMapper)
    {
        $this->fileTransferRequestMapper = $fileTransferRequestMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllFileTransferRequests()
    {
        return $this->fileTransferRequestMapper->findAll();
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findFileTransferRequest($id)
    {
        return $this->fileTransferRequestMapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveFileTransferRequest(FileTransferRequest $fileTransferRequest)
    {
        return $this->fileTransferRequestMapper->save($fileTransferRequest);
    }
}
