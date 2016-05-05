<?php
namespace Order\Service;

use Order\Mapper\FileTransferRequestMapperInterface;
use DbSystel\DataObject\FileTransferRequest;

class FileTransferRequestService extends AbstractService implements FileTransferRequestServiceInterface
{

    /**
     *
     * @var FileTransferRequestMapperInterface
     */
    protected $mapper;

    /**
     *
     * @param FileTransferRequestMapperInterface $mapper
     */
    public function __construct(FileTransferRequestMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllWithBuldledData()
    {
        return $this->mapper->findAllWithBuldledData();
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findFileTransferRequest($id)
    {
        return $this->mapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveFileTransferRequest(FileTransferRequest $fileTransferRequest)
    {
        return $this->mapper->save($fileTransferRequest);
    }

}
