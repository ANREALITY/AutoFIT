<?php
namespace Order\Mapper;

use DbSystel\DataObject\AccessConfig;

interface AccessConfigMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return AccessConfig
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     *
     * @return array|AccessConfig[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param AccessConfig $dataObject
     * @param boolean $updateIfIdSet
     * @return AccessConfig
     * @throws \Exception
     */
    public function save(AccessConfig $dataObject, bool $updateIfIdSet = false);

    /**
     *
     * @param array $criteria
     * @throws \Exception
     */
    public function deleteAll(array $criteria);

}
