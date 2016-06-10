<?php
namespace Order\Service;

use Order\Mapper\SynchronizationMapperInterface;
use DbSystel\DataObject\Synchronization;

class SynchronizationService extends AbstractService implements SynchronizationServiceInterface
{

    /**
     *
     * @var SynchronizationMapperInterface
     */
    protected $mapper;

    /**
     *
     * @param SynchronizationMapperInterface $mapper
     */
    public function __construct(SynchronizationMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAll()
    {
        return $this->mapper->findAll();
    }

}
