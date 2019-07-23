<?php
namespace Order\Service;

use Doctrine\ORM\Query;
use Order\Mapper\AbstractMapper;
use Order\Mapper\FileTransferRequestMapperInterface;
use Base\DataObject\FileTransferRequest;

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
    public function findAll(array $criteria = [], $page = null, array $sorting = [])
    {
        return $this->mapper->findAllPaginated($criteria, $page, $sorting);
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
     * {@inheritDoc}
     */
    public function findAllForAutocomplete(string $changeNumber = null)
    {
        return $this->mapper->findAll(
            [
                'change_number' => $changeNumber
            ],
            AbstractMapper::DEFAULT_QUERY_LIMIT,
            Query::HYDRATE_ARRAY
        );
    }

}
