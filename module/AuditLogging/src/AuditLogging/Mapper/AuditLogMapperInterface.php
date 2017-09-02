<?php
namespace AuditLogging\Mapper;

use DbSystel\DataObject\AuditLog;

interface AuditLogMapperInterface
{

    /**
     *
     * @return array|AuditLog[]
     */
    public function findAll(array $criteria = [], $id = null, $page = null, array $sorting = []);

    /**
     *
     * @param AuditLog $dataObject
     * @return AuditLog
     * @throws \Exception
     */
    public function save(AuditLog $dataObject);

}
