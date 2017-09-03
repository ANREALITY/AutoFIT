<?php
namespace AuditLogging\Mapper;

use DbSystel\DataObject\AuditLog;
use DbSystel\Paginator\Paginator;

interface AuditLogMapperInterface
{

    /**
     * @param $id
     * @return AuditLog
     */
    public function findOne($id);

    /**
     * @param array $criteria
     * @param null $page
     * @param array $sorting
     * @return Paginator
     */
    public function findAll(array $criteria = [], $page = null, array $sorting = []);

    /**
     *
     * @param AuditLog $dataObject
     * @return AuditLog
     * @throws \Exception
     */
    public function save(AuditLog $dataObject);

}
