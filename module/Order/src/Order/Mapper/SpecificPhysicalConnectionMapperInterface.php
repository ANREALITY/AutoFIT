<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractSpecificPhysicalConnection;

interface SpecificPhysicalConnectionMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return AbstractSpecificPhysicalConnection
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     *
     * @return array|AbstractSpecificPhysicalConnection[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param AbstractSpecificPhysicalConnection $dataObject
     * @return AbstractSpecificPhysicalConnection
     * @throws \Exception
     */
    public function save(AbstractSpecificPhysicalConnection $dataObject);
}
