<?php
namespace AuditLogging\Mapper;

use DbSystel\DataObject\AuditLog;

interface AuditLogMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return AuditLog
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     *
     * @return array|AuditLog[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param AuditLog $dataObject
     * @return AuditLog
     * @throws \Exception
     */
    public function save(AuditLog $dataObject);

}
