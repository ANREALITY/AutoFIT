<?php
namespace Order\Mapper;

use DbSystel\DataObject\AccessConfigSet;

interface AccessConfigSetMapperInterface
{

    /**
     *
     * @param AccessConfigSet $dataObject
     * @return AccessConfigSet
     * @throws \Exception
     */
    public function save(AccessConfigSet $dataObject);

    /**
     *
     * @param integer $id
     */
    public function delete($id);

}
