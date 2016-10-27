<?php
namespace AuditLogging\Service;

use AuditLogging\Mapper\AuditLogMapperInterface;
use DbSystel\DataObject\AuditLog;
use Order\Service\AbstractService;

class AuditLogService extends AbstractService implements AuditLogServiceInterface
{

    /**
     *
     * @var AuditLogMapperInterface
     */
    protected $mapper;

    /**
     *
     * @param AuditLogMapperInterface $mapper
     */
    public function __construct(AuditLogMapperInterface $mapper)
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
        return $this->mapper->findAll([]);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveOne(AuditLog $auditLog)
    {
        return $this->mapper->save($auditLog);
    }

}
