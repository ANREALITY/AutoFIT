<?php
namespace FileTransferRequest\Service;

use FileTransferRequest\Mapper\PhysicalConnectionMapperInterface;
use DbSystel\DataObject\AbstractPhysicalConnection;

class PhysicalConnectionService implements PhysicalConnectionServiceInterface
{

    /**
     *
     * @var PhysicalConnectionMapperInterface
     */
    protected $physicalConnectionMapper;

    /**
     *
     * @param PhysicalConnectionMapperInterface $physicalConnectionMapper
     */
    public function __construct(PhysicalConnectionMapperInterface $physicalConnectionMapper)
    {
        $this->physicalConnectionMapper = $physicalConnectionMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllPhysicalConnections()
    {
        return $this->physicalConnectionMapper->findAll();
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findPhysicalConnection($id)
    {
        return $this->physicalConnectionMapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function savePhysicalConnection(AbstractPhysicalConnection $physicalConnection)
    {
        return $this->physicalConnectionMapper->save($physicalConnection);
    }
}
