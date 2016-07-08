<?php
namespace Order\Mapper;

use DbSystel\DataObject\AccessConfigSet;

interface AccessConfigSetMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return AccessConfigSet
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     *
     * @return array|AccessConfigSet[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param AccessConfigSet $dataObject
     * @return AccessConfigSet
     * @throws \Exception
     */
    public function save(AccessConfigSet $dataObject);

    /**
     *
     * @param integer $id
     */
    public function delete($id);

}
