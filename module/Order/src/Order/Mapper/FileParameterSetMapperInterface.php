<?php
namespace Order\Mapper;

use DbSystel\DataObject\FileParameterSet;

interface FileParameterSetMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return FileParameterSet
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     *
     * @return array|FileParameterSet[]
     */
    public function findAll(array $criteria = []);

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
