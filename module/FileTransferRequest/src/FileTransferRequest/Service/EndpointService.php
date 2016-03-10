<?php
namespace FileTransferRequest\Service;

use FileTransferRequest\Mapper\EndpointMapperInterface;
use DbSystel\DataObject\AbstractEndpoint;

class EndpointService implements EndpointServiceInterface
{

    /**
     *
     * @var EndpointMapperInterface
     */
    protected $endpointMapper;

    /**
     *
     * @param EndpointMapperInterface $endpointMapper
     */
    public function __construct(EndpointMapperInterface $endpointMapper)
    {
        $this->endpointMapper = $endpointMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllEndpoints()
    {
        return $this->endpointMapper->findAll();
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findEndpoint($id)
    {
        return $this->endpointMapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveEndpoint(AbstractEndpoint $endpoint)
    {
        return $this->endpointMapper->save($endpoint);
    }
}
