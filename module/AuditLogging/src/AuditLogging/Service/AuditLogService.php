<?php
namespace AuditLogging\Service;

use AuditLogging\Mapper\AuditLogMapperInterface;
use Base\DataObject\AuditLog;
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
    public function findAll(array $criteria = [], $page = null, array $sorting = [])
    {
        return $this->mapper->findAllPaginated($criteria, $page, $sorting);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function create(AuditLog $auditLog)
    {
        return $this->mapper->create($auditLog);
    }

}
