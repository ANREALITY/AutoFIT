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
    public function findAll(array $criteria = [], $id = null, $page = null, $requstMode = AuditLogRequestModifier::REQUEST_MODE_REDUCED, array $sorting = [])
    {
        return $this->mapper->findAll($criteria, $id, $page, $requstMode, $sorting);
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
