<?php
namespace Order\Mapper;

use DbSystel\DataObject\LogicalConnection;

interface LogicalConnectionMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return LogicalConnection
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     *
     * @return array|LogicalConnection[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param LogicalConnection $dataObject
     * @return LogicalConnection
     * @throws \Exception
     */
    public function save(LogicalConnection $dataObject);

}
