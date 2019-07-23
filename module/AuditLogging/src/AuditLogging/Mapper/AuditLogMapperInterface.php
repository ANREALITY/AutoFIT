<?php
namespace AuditLogging\Mapper;

use Base\DataObject\AuditLog;
use Base\Paginator\Paginator;

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
    public function findAllPaginated(array $criteria = [], $page = null, array $sorting = []);

    /**
     *
     * @param AuditLog $dataObject
     * @return AuditLog
     * @throws \Exception
     */
    public function create(AuditLog $dataObject);

}
