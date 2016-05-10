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
    public function findAllWithBuldledData(array $criteria = [], $id = null)
    {
        return $this->mapper->findAllWithBuldledData($criteria, $id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveOne(FileTransferRequest $fileTransferRequest)
    {
        return $this->mapper->save($fileTransferRequest);
    }

}
