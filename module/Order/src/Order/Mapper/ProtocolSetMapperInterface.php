<?php
namespace Order\Mapper;

use DbSystel\DataObject\ProtocolSet;

interface ProtocolSetMapperInterface
{

    /**
     *
     * @param ProtocolSet $dataObject
     * @return ProtocolSet
     * @throws \Exception
     */
    public function save(ProtocolSet $dataObject);

    /**
     *
     * @param integer $id
     */
    public function delete($id);

}
