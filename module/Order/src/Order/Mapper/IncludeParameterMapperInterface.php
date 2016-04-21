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
    public function find($id);

    /**
     *
     * @return array|IncludeParameter[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param IncludeParameter $dataObject
     * @return IncludeParameter
     * @throws \Exception
     */
    public function save(IncludeParameter $dataObject);

    /**
     *
     * @param array $criteria
     * @throws \Exception
     */
    public function deleteAll(array $criteria);

}
