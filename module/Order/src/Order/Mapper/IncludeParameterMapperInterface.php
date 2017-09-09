<?php
namespace Order\Mapper;

use DbSystel\DataObject\IncludeParameter;

interface IncludeParameterMapperInterface
{

    /**
     *
     * @param IncludeParameter $dataObject
     * @param boolean $updateIfIdSet
     * @return IncludeParameter
     * @throws \Exception
     */
    public function save(IncludeParameter $dataObject, bool $updateIfIdSet = false);

    /**
     *
     * @param array $criteria
     * @throws \Exception
     */
    public function deleteAll(array $criteria);

}
