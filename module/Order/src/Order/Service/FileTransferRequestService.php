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
    public function findAll(array $criteria = [], $page = null)
    {
        return $this->mapper->findAllPaginated($criteria, $page);
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

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllForAutocomplete(string $changeNumber = null)
    {
        return $this->mapper->findAllPaginated(
            [
                [
                    'change_number' => $changeNumber
                ]
            ]);
    }

}
