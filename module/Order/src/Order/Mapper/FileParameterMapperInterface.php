<?php
namespace Order\Mapper;

use DbSystel\DataObject\FileParameter;

interface FileParameterMapperInterface
{

    /**
     *
     * @param array $criteria
     * @throws \Exception
     */
    public function deleteAll(array $criteria);

}
