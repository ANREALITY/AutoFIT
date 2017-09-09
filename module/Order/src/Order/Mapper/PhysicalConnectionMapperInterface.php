<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractPhysicalConnection;

interface PhysicalConnectionMapperInterface
{

    /**
     *
     * @param AbstractPhysicalConnection $dataObject
     * @return AbstractPhysicalConnection
     * @throws \Exception
     */
    public function save(AbstractPhysicalConnection $dataObject);

}
