<?php
namespace Order\Mapper;

use DbSystel\DataObject\FileParameter;

interface FileParameterMapperInterface
{

    /**
     *
     * @param FileParameter $dataObject
     * @param boolean $updateIfIdSet
     * @return FileParameter
     * @throws \Exception
     */
    public function save(FileParameter $dataObject, bool $updateIfIdSet = false);

    /**
     *
     * @param array $criteria
     * @throws \Exception
     */
    public function deleteAll(array $criteria);

}
