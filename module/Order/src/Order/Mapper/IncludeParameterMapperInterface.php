<?php
namespace Order\Mapper;

use DbSystel\DataObject\IncludeParameter;

interface IncludeParameterMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return IncludeParameter
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     *
     * @return array|IncludeParameter[]
     */
    public function findAll(array $criteria = []);

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
