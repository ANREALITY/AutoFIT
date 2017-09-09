<?php
namespace Order\Mapper;

use DbSystel\DataObject\LogicalConnection;

interface LogicalConnectionMapperInterface
{

    /**
     *
     * @param LogicalConnection $dataObject
     * @return LogicalConnection
     * @throws \Exception
     */
    public function save(LogicalConnection $dataObject);

}
