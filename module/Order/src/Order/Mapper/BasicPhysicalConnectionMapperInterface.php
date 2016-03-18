<?php
namespace Order\Mapper;

use DbSystel\DataObject\BasicPhysicalConnection;

interface BasicPhysicalConnectionMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return BasicPhysicalConnection
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|BasicPhysicalConnection[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param BasicPhysicalConnection $dataObject
     * @return BasicPhysicalConnection
     * @throws \Exception
     */
    public function save(BasicPhysicalConnection $dataObject);
}
