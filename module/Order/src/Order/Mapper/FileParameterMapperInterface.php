<?php
namespace Order\Mapper;

use DbSystel\DataObject\FileParameter;

interface FileParameterMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return FileParameter
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     *
     * @return array|FileParameter[]
     */
    public function findAll(array $criteria = []);

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
