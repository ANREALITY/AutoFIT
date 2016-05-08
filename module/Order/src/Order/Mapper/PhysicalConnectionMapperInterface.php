<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractPhysicalConnection;

interface PhysicalConnectionMapperInterface
{

    /**
     *
     * @param int|string $id            
     * @return AbstractPhysicalConnection
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     *
     * @return array|AbstractPhysicalConnection[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param AbstractPhysicalConnection $dataObject            
     * @return AbstractPhysicalConnection
     * @throws \Exception
     */
    public function save(AbstractPhysicalConnection $dataObject);

}
