<?php
namespace Order\Mapper;

use DbSystel\DataObject\ProtocolSet;

interface ProtocolSetMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return ProtocolSet
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     *
     * @return array|ProtocolSet[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param ProtocolSet $dataObject
     * @return ProtocolSet
     * @throws \Exception
     */
    public function save(ProtocolSet $dataObject);

    /**
     *
     * @param integer $id
     */
    public function delete($id);

}
