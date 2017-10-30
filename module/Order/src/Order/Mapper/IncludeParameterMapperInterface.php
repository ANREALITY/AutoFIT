<?php
namespace Order\Mapper;

use DbSystel\DataObject\IncludeParameter;

interface IncludeParameterMapperInterface
{

    /**
     *
     * @param array $criteria
     * @throws \Exception
     */
    public function deleteAll(array $criteria);

}
