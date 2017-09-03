<?php
namespace AuditLogging\Service;

use AuditLogging\Mapper\AuditLogMapperInterface;
use DbSystel\DataObject\AuditLog;
use Order\Service\AbstractService;
use AuditLogging\Mapper\RequestModifier\AuditLogRequestModifier;

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
    public function findAll(array $criteria = [], $page = null, array $sorting = [])
    {
        return $this->mapper->findAll($criteria, $page, $sorting);
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
