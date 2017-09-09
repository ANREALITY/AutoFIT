<?php
namespace Order\Mapper;

use DbSystel\DataObject\IncludeParameterSet;

interface IncludeParameterSetMapperInterface
{

    /**
     *
     * @param IncludeParameterSet $dataObject
     * @return IncludeParameterSet
     * @throws \Exception
     */
    public function save(IncludeParameterSet $dataObject);

    /**
     *
     * @param integer $id
     */
    public function delete($id);

}
