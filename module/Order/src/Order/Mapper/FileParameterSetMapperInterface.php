<?php
namespace Order\Mapper;

use DbSystel\DataObject\FileParameterSet;

interface FileParameterSetMapperInterface
{

    /**
     *
     * @param FileParameterSet $dataObject
     * @return FileParameterSet
     * @throws \Exception
     */
    public function save(FileParameterSet $dataObject);

    /**
     *
     * @param integer $id
     */
    public function delete($id);

}
