<?php
namespace Order\Mapper;

use DbSystel\DataObject\IncludeParameterSet;

interface IncludeParameterSetMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return IncludeParameterSet
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     *
     * @return array|IncludeParameterSet[]
     */
    public function findAll(array $criteria = []);

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
