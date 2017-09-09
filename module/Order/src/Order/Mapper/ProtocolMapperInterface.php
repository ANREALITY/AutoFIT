<?php
namespace Order\Mapper;

use DbSystel\DataObject\Protocol;

interface ProtocolMapperInterface
{

    /**
     *
     * @param Protocol $dataObject
     * @return Protocol
     * @throws \Exception
     */
    public function save(Protocol $dataObject);

}
